$(function () {
    

    $('.btn-group').on('click', function () {
        $('.modal-footer button[type=submit]').value('tambah Data');
    });

    $('.tampilModalUbah').on('click', function () {
        $('#exampleModalLabel').html('Ubah Data');
        $('.modal-footer button[type=submit]').html('Ubah Data');


        const id = $(this).data('id');



        $.ajak({
            url: 'http://localhost/project/function/getubah',
            data: {id : id},
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
        });

    });
});