setInterval(function () {
    //mengambil value dalam ckeditor
    if (editor_template) {
      editor_template.innerHTML = document.getElementById("konten").value;
    }
    //tombol selanjutnya enable
    if(titleForm.value==="") { 
        document.getElementById('next1').disabled = true; 
        } else { 
        document.getElementById('next1').disabled = false;
    }
}, 5);
// ===================================================
// Javascript Wizard Form
// ===================================================
var titleForm = document.getElementById('titleForm');
var editor_template = document.getElementById("editor_template");
    
document.getElementById('titleFormOutput').innerHTML = toTitleCase(titleForm.value);

document.getElementById('titleForm').value = toTitleCase(titleForm.value);

titleForm.onkeyup = function(){
document.getElementById('titleFormOutput').innerHTML = toTitleCase(titleForm.value);

document.getElementById('titleForm').value = toTitleCase(titleForm.value);
}

function toTitleCase(str) {
    return str.split(/\s+/).map( s => s.charAt( 0 ).toUpperCase() + s.substring(1).toLowerCase() ).join( " " );
}

function removeSpaces(str) {
    return str.split(' ').join('');
}
