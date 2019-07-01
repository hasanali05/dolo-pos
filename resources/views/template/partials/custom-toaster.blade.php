<script>
	$(document).ready(function() {            
            @if(session()->has('success'))
                $.toast({
                    heading: 'Success',
                    text: '{{ session()->pull('success') }}',
                    position: 'top-right',
                    loaderBg:'#0000ff',
                    icon: 'success',
                    hideAfter: 4500, 
                    stack: 5
                });
            @endif
            @if(session()->has('error'))
                $.toast({
                    heading: 'Error',
                    text: '{{ session()->pull('error') }}',
                    position: 'top-right',
                    loaderBg:'#0000ff',
                    icon: 'error',
                    hideAfter: 4500, 
                    stack: 5
                });
            @endif
            @if(session()->has('warning'))
                $.toast({
                    heading: 'Warning',
                    text: '{{ session()->pull('warning') }}',
                    position: 'top-right',
                    loaderBg:'#0000ff',
                    icon: 'warning',
                    hideAfter: 4500, 
                    stack: 5
                });
            @endif
            @if(session()->has('info'))
                $.toast({
                    heading: 'Information',
                    text: '{{ session()->pull('info') }}',
                    position: 'top-right',
                    loaderBg:'#0000ff',
                    icon: 'info',
                    hideAfter: 4500, 
                    stack: 5
                });
            @endif

            @if(session()->has('errors'))
            var errors = '{{ session()->pull('errors') }}';
            for (var key in errors) {
                    $.toast({
                        heading: 'Error',
                        text: key,
                        position: 'top-right',
                        loaderBg:'#0000ff',
                        icon: 'error',
                        hideAfter: 4500, 
                        stack: 5
                    }); 
            }
            @endif
        });
</script>
