//frontDispatcher_2.0
//Maneja la interaccion entre el backend y frontend

const API_URL = '../backend/server.php?module=students';

//Define la URL de backend que se utilizará en todas las llamadas que vea fetch()
//Se define en una constante porque es más fácil si luego tengo que hacer modificaciones.

document.addEventListener('DOMContentLoaded', () => 
//DOMContentLoaded hace que primero cargue todo el HTML.
//Mas que nada lo tengo que usar si incluyo js en el head del HTML y no en el final del body
{
    const studentForm = document.getElementById('studentForm');
    const studentTableBody = document.getElementById('studentTableBody');
    //los que siguen son de los input donde llena el cliente los datos
    const fullnameInput = document.getElementById('fullname');
    const emailInput = document.getElementById('email');
    const ageInput = document.getElementById('age');
    const studentIdInput = document.getElementById('studentId');

    // Leer todos los estudiantes al cargar
    fetchStudents(); //función desarrollada mas abajo

    // Formulario: Crear o actualizar estudiante
    studentForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        //evita que se recargue la pagina al hacer "guardar"
        const formData = {
            fullname: fullnameInput.value,
            email: emailInput.value,
            age: ageInput.value,
        };

        const id = studentIdInput.value;
        const method = id ? 'PUT' : 'POST';
        //Si hay un id, edita (PUT). Sino, es nuevo (POST)
        if (id) formData.id = id;

        try 
        {
            const response = await fetch(API_URL, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData),
            });

            if (response.ok) {
                studentForm.reset();
                studentIdInput.value = '';
                await fetchStudents();
            } else {
                alert("Error al guardar");
            }
        } catch (err) {
            console.error(err);
        }
    });

    // Obtener estudiantes y renderizar tabla
    async function fetchStudents() 
    {
        try 
        {
            const res = await fetch(API_URL);
            //Solicitud GET al backend que viene en JSON
            const students = await res.json();
            //Lo convierte en un array

            //Limpiar tabla de forma segura.
            studentTableBody.replaceChildren();
            //acá innerHTML es seguro a XSS porque no hay entrada de usuario
            //igual no lo uso.
            //studentTableBody.innerHTML = "";

            students.forEach(student => { //recorre de a uno el array
                //Creo una fila por el primer elemento que leo
                const tr = document.createElement('tr');

                //Comienzo a crear las celdas
                const tdName = document.createElement('td');
                tdName.textContent = student.fullname;

                const tdEmail = document.createElement('td');
                tdEmail.textContent = student.email;

                const tdAge = document.createElement('td');
                tdAge.textContent = student.age;

                const tdActions = document.createElement('td');
                const editBtn = document.createElement('button');
                editBtn.textContent = 'Editar';
                editBtn.classList.add('edit', 'w3-large', 'w3-margin-right');
                editBtn.onclick = () => {
                    fullnameInput.value = student.fullname;
                    emailInput.value = student.email;
                    ageInput.value = student.age;
                    studentIdInput.value = student.id;
                };

                const deleteBtn = document.createElement('button');
                deleteBtn.textContent = 'Borrar';
                deleteBtn.classList.add('del', 'w3-large');
                deleteBtn.onclick = () => deleteStudent(student.id); //funcion desarrollada abajo

                tdActions.appendChild(editBtn);
                tdActions.appendChild(deleteBtn);

                //Agrego todas las celdas a esa fila
                tr.appendChild(tdName);
                tr.appendChild(tdEmail);
                tr.appendChild(tdAge);
                tr.appendChild(tdActions);

                //Agrego la fila a la tabla
                studentTableBody.appendChild(tr);
            });
        } catch (err) {
            console.error("Error al obtener estudiantes:", err);
        }
    }

    // Eliminar estudiante
    async function deleteStudent(id) 
    {
        if (!confirm("¿Seguro que querés borrar este estudiante?")) return;

        try 
        {
            const response = await fetch(API_URL, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id }),
                //Solicitud DELETE con el id en el cuerpo JSON
            });

            if (response.ok) {
                await fetchStudents(); //Me carga la tabla de nuevo y sin el elemento
            } else {
                alert("Error al borrar");
            }
        } catch (err) {
            console.error(err);
        }
    }
});
