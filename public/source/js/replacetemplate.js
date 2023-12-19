$(document).ready(function () {
    //Date range picker
    // $("#reservationdate").datetimepicker({
    //     format: "L",
    // });
    //menghilangkan style kalau copas
    document.addEventListener("paste", function (e) {
        e.preventDefault();
        var text = (e.originalEvent || e).clipboardData.getData("text/plain");
        document.execCommand("insertHTML", false, text);
    });

    // replace variable
    var spans = document.getElementsByClassName("input-variable");
    for (let i = 0, ln = spans.length; i < ln; i++) {
        var span = spans[i];
        span.addEventListener("DOMCharacterDataModified", function () {
            let cls = this.className;
            let id = cls.replace("input-variable ", "");
            let val = this.innerHTML;

            let childNode = document.getElementsByClassName(id);
            for (let j = 0, ln1 = childNode.length; j < ln1; j++) {
                if (childNode[j].innerHTML != val) {
                    childNode[j].innerHTML = val;
                }
            }
        });

        // utk input variable, jika enter maka dilarang
        span.addEventListener("keydown", function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });

        var mutateObserver = new MutationObserver(function (records) {});

        mutateObserver.observe(span, {
            childList: true,
            characterData: true,
            subtree: true,
            characterDataOldValue: true,
        });
    }

    $(".input-list")
        .closest("ol")
        .add($(".input-list").closest("ul"))
        .prop("contentEditable", "true");

    // jika variable dihapus maka akan mengembalikan variable. Untuk mencegah variable dihapus sehingga tidak bisa diedit
    $(".input-variable").on("blur", function () {
        if ($(this).text() == "") {
            var variableName = $(this).attr("name");
            $(".input-" + variableName).text(
                "{{" + $(this).attr("name") + "}}"
            );
        }
    });

    // replace variable end
});

function checknomordokumen() {
    // var action = false;
    // var nodokumen = document.getElementsByClassName('input-nomordokumen');
    // var nomordokumen = nodokumen[0].innerHTML.trim();
    // $.ajax({
    //     url: "surat/check_nomordokumen",
    //     data: {
    //         nomordokumen: nomordokumen
    //     },
    //     type: 'POST',
    //     global: false,
    //     async: false, //blocks window close
    //     success: function(data) {
    //         if (data == '0') {
    //             $("#msgbox").fadeTo(200, 0.1, function() {
    //                 $(this).html('<span style="color:red">Nomor dokumen sudah ada atau tidak bisa digunakan, gunakan nomor dokumen lain!</span>').addClass('messageboxerror').fadeTo(900, 1);
    //             });
    //             action = false;
    //         } else if (data == '1') {
    //             document.getElementById('nomordokumen').value = nomordokumen;
    //             action = true;
    //         }
    //     }
    // });
    // return action;
}

// nambah baris dan hapus baris
function addRow(id_table) {
    var mainTable = document.getElementById(id_table);
    var tbody = mainTable.children[0];

    var length = tbody.rows.length;
    var row = length - 2;
    tbody.insertBefore(
        mainTable.rows[row].cloneNode(true),
        mainTable.rows[row]
    );
}

function deleteRow(id_table) {
    var mainTable = document.getElementById(id_table);
    var tbody = mainTable.children[0];

    var length = tbody.rows.length;
    var row = length - 2;
    document.getElementById(id_table).deleteRow(row);
}
// nambah baris dan hapus baris end

setInterval(function () {
    document.getElementById("konten").value =
        document.getElementById("preview").innerHTML;

    var str = document.getElementById("konten").value;
    var res = str.replaceAll('contenteditable="true"', "");
    var res2 = res.replaceAll('contentEditable="true"', "");
    var res3 = res2.replaceAll("[add row]", "");
    var res4 = res3.replaceAll("[delete row]", "");

    var res5 = res4.replaceAll(/\{{(.+?)\}}/g, "");

    document.getElementById("last-priview").innerHTML = res5;
}, 5);

const textarea = document.querySelector("#preview");
// const inputs = document.querySelector('#nomordokumen');

const template = textarea.innerHTML;

function update() {
    textarea.innerHTML = inputs.reduce(
        (acc, i) =>
            acc.replace(
                new RegExp(`\\{\\{\\s*${i.id}\\s*\\}\\}`, "g"),
                i.value
            ),
        template
    );
}
// if (inputs.length > 0)
//     inputs.forEach(e => e.addEventListener('input', update));
