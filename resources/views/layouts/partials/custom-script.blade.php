<script>
    const DeleteConfirmation = swal.mixin({
        title: 'Are you sure?',
        text: "This data will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
    })
    const SendConfirmation = swal.mixin({
        title: 'This Message will be Send',
        text: "",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#13b90e',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Duplicate',
        cancelButtonText: 'Batal',
    })
    const CopyConfirmation = swal.mixin({
        title: 'This segment will be duplicate',
        text: "include them product segment",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#13b90e',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Duplicate',
        cancelButtonText: 'Cancel',
    })

    const Toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', swal.stopTimer)
            toast.addEventListener('mouseleave', swal.resumeTimer)
        }
    })
    
    function toast(icon, message){
        Toast.fire({
            icon: icon,
            title: message
        })
    }
    
    function basicFormSuccess(message, status){
        return toast('success', message)
    }

    function basicFormError(payload){
        // console.log(payload)

        // Warning, ex: Date range validation
        if (payload.response.status == 406) return swal.fire( 'Warning!', payload.response.data.message, 'warning' )
        
        // Error, ex: Delete Failed Because Have Foreign Key
        if (payload.response.status == 409) return swal.fire( 'Gagal!', payload.response.data.message, 'error' )

        // Form Validation fail
        if (payload.response.status == 422) return toast('error', 'Terjadi kesalahan, periksa kembali data anda')
        
        // Unknown Error
        return toast('error', 'Terjadi kesalahan')
    }
    
    function redrawTable(){
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth: true,
            width: 'auto'
        });
    }

    function select2Error(val, index){        
        var style = (val ? 
            'border-color: #F44336 !important; color: #F44336 !important' :
            'border-color: #d1d1d1 !important; color: #324148 !important' );

        if ($('.select2-selection--single')[index] != 'undefined') {
            $('.select2-selection--single')[index].setAttribute('style', style)
        }
    }

    function formUniformError(val, index){        
        var style = (val ? 
            'border-color: #F44336 !important; color: #F44336 !important' :
            'border-color: #ddd !important; color: #333 !important' );

        if ($('.uniform-select')[index] != 'undefined') {
            $('.uniform-select')[index].setAttribute('style', style)
        }
    }

    function laddaButton(btnClass){
        return Ladda.create(document.querySelector(btnClass))
    }
</script>