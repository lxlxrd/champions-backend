{{-- scritp footer --}}
<script src="{{ asset('new/assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('new/assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('new/assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('new/assets/js/fonts/custom-font.js') }}"></script>
<script src="{{ asset('new/assets/js/pcoded.js') }}"></script>
<script src="{{ asset('new/assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('new/assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="{{ asset('new/assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
<script src="{{ asset('new/assets/js/plugins/choices.min.js') }}"></script>

<script>
    layout_change('light');
</script>
<script>
    layout_theme_contrast_change('false');
</script>
<script>
    change_box_container('false');
</script>
<script>
    layout_caption_change('true');
</script>
<script>
    layout_rtl_change('false');
</script>
<script>
    preset_change("preset-1");
</script>

@include('layouts.new.deleteScript')

  

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var genericExamples = document.querySelectorAll('[data-trigger]');
        for (i = 0; i < genericExamples.length; ++i) {
            var element = genericExamples[i];
            new Choices(element, {
                placeholderValue: 'This is a placeholder set in the config',
                searchPlaceholderValue: 'Saisissez pour chercher dans la liste',
                itemSelectText: 'Cliquer pour choisir',
                placeHolder: false,
            });
        }
    });
</script>
@yield('script')