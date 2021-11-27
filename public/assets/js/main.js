const notes = document.getElementById('notes');

if(notes) {
    notes.addEventListener('click', e => {
        if(e.target.className === 'btn btn-danger delete-note m-2'){
            if(confirm('Are you sure?')) {
                const id = e.target.getAttribute('data-id');
                fetch(`/note/delete/${id}`, {
                    method: `DELETE`
                }).then(res => window.location.reload());
            }
        }
    });
}

const tags = document.getElementById('tags');

if(tags) {
    tags.addEventListener('click', e => {
        if(e.target.className === 'btn btn-danger delete-tag m-2'){
            if(confirm('Are you sure?')) {
                const name = e.target.parentElement.childNodes[0].textContent.trim();
                fetch(`/tag/delete/${name}`, {
                    method: `DELETE`
                }).then(res => console.log(res));
            }
        }
    });
}
