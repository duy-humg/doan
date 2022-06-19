$(document).ready(function () {
    $('.faqSectionFirst .faqTextFirst').each(function () {
        $(this).hide();
    });

    $('.faqSectionFirst').on("click", function () {
        $('h2', this).toggleClass('active');
        $('.faqTextFirst', this).slideToggle();		
    });
});