function formAction(form, action) {
    action.preventDefault();
    let $idForm = $(form).attr("id");
    $.post({
        url: $(form).attr("action"),
        data: $(form).serialize(),
        success: (res) => {
            if (res.register = "success1") {
                window.location.href = "/";
            }
            if (res.auth = "success1") {
                window.location.href = "/";
            }
            if (res.admin = "success1") {
                window.location.href = "/";
            }
            if (res.order = "success") {
                window.location.reload();
            }
        },
        error: (res) => {
            $("form#" + $idForm + " input").removeClass("is-invalid");
            $("form#" + $idForm + " div.invalid-feedback").text("");

            $.each(res.responseJSON, function (index, value) {
                $("form#" + $idForm + " input#" + index + "Input").addClass(
                    "is-invalid"
                );
                $("form#" + $idForm + " div#" + index + "Error").text(value);
            });
        },
    });
}

function addBin(id) {
    $.get({
        url: "/addBin",
        data: {
            id: id,
        },
        success: (res) => {
            if ((res.bin = "success")) {
                window.location.reload();
            }
        },
        error: (res) => {
            if (res.responseJSON["bin"]) {
                $("div#error").show("slow");
                setTimeout(() => {
                    $("div#error").hide("slow");
                }, "1000");
            }
        },
    });
}
function sorting(id, type) {
    $.get({
        url: "/sorting",
        data: {
            id: id,
            type: type,
        },
        success: (res) => {
            $("div#items").html(res);
        },
        error: (res) => {
            console.log(res);
        },
    });
}

function changeCount(id, type) {

   
    $.get({
        url: "/bin/changeCount",
        data: {
            id: id,
            type: type,
        },
        success: (res) => {
           $('span#count'+ id).text(res.count);
           $('span#sumPrice'+ id).text(res.sumPrice);
           $('span#sum').text(res.sum);
        },
        error: (res) => {
            if (res.responseJSON["bin"]) {
                $("div#error").show("slow");
                setTimeout(() => {
                    $("div#error").hide("slow");
                }, "1000");
            }
            if (res.responseJSON["error"]) {
                $("div#error1").show("slow");
                setTimeout(() => {
                    $("div#error1").hide("slow");
                }, "1000");
            }

        },
    });
}

function filter(t) {
    let status = $(t).val();
    $.ajax({
        url: "/filter",
        type: 'GET',
        data: {
        status:status,
        },
        success: (res) => {
           $('div#orders').html(res);
        },
        error: (res) => {
            console.log(res);
        },
    });
}
function selectStatus(t, id) {
    let status = $(t).val();

    $('form#twoForm' + id).slideUp();
    $('form#threeForm' + id).slideUp();

    $('form#' + status + id).slideDown(300);
}

function removeItem(itemId, event) {
    if (confirm('Удалить товар из корзины?')) {
        let token = document.querySelector('meta[name="csrf-token"]');
        
        if (!token) {
            alert('CSRF токен не найден!');
            return;
        }
        
        token = token.getAttribute('content');
        
        fetch('/bin/remove-item', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ 
                id: itemId 
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Находим родительскую строку и удаляем
                const row = event.target.closest('.row.mt-4, tr');
                if (row) {
                    row.remove();
                }
                
                // Обновляем сумму
                if (document.getElementById('sum')) {
                    document.getElementById('sum').innerText = data.totalSum;
                }
                
                // Проверяем осталась ли корзина пустой
                const items = document.querySelectorAll('.row.mt-4');
                if (items.length === 0) {
                    location.reload();
                }
            } else {
                alert('Ошибка при удалении: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка при удалении товара');
        });
    }
}


