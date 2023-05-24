<!DOCTYPE html>
<html>
<body>
</body>
<script defer>
    window.onload= setTimeout(waitLoad, 500)

    function waitLoad(){
        document.write(localStorage.getItem('bag'))
    };
</script>
</html>
