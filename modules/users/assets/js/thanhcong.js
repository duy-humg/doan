$(document).ready(function () {
   
    new_url = $('#link_home').val();

    const myTimeout = setTimeout(myGreeting, 12000);

    function myGreeting() {
        location.href = new_url;
    }
});