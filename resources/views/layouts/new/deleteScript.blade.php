@include('layouts.new.deleteForm')
<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    function showDeleteModal(action) {
        swalWithBootstrapButtons
            .fire({
                title: 'Voulez vous supprimer cet élément ?',
                text: "Cette action sera irreversible !!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Non, annuler!',
                reverseButtons: true
            })
            .then((result) => {
                if (result.isConfirmed) {
                  
                    let _deleteForm = document.getElementById('deleteForm');
                    _deleteForm.setAttribute('action', action);
                    _deleteForm.submit();

                    // swalWithBootstrapButtons.fire('Supprimer!',
                    //     'Elément supprimer avec succes.', 'success');
                    // window.location.reload();

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire('Annuler',
                        'L\'élement sera toujours présent :)', 'error');
                }
            });
    }
</script>