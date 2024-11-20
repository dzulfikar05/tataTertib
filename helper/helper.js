$(()=> {
    $('.required-label').append('<span class="text-danger">*</span>'); 
});

resetForm = (listId = []) => {
    $.each(listId, (i, id) => {
        $(`#${id}`).val('').trigger('change');
        $('.textarea-' + listForm[i]).html();         
    });
}

editForm = (listId = [],  data) => {
    for (i = 0; i < listId.length; i++) {
        $('#' + listForm[i]).val(data[listForm[i]]).trigger('change');   
        $('.textarea-' + listForm[i]).html(data[listForm[i]]);         
    }
}

onConfirm = (message, callback) => {
    Swal.fire({
        title: "Apakah anda yakin?",
        text: message,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText: "Batal"
    }).then((result) => {
        callback(result);
    });
}

onAlert = (title, message, icon) => {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        confirmButtonColor: "#3b7ddd"
    });
}

formaterDate = (date) => {
    return moment(date).format('DD MMMM YYYY');
}

