var index_slide = 1;
montrerSlides(index_slide);

function changerSlide(n) {
    montrerSlides(index_slide += n);
}

function slideActuel(n) {
    montrerSlides(index_slide = n);
}

function montrerSlides(n) {
    var i;
    var slides = document.getElementsByClassName("slide");
    var points = document.getElementsByClassName("pt");
    if (n > slides.length)
        index_slide = 1;
    if (n < 1)
        index_slide = slides.length;
    for (i = 0; i < slides.length; i++)
        slides[i].style.display = "none";
    for (i = 0; i < points.length; i++)
        points[i].className = points[i].className.replace(" active", "");
    slides[index_slide - 1].style.display = "block";
    points[index_slide - 1].className += " active";
}