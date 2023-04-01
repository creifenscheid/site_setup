window.addEventListener('DOMContentLoaded', (event) => {

  // lightbox
  // @SeppToDo localization
  const prvs = new Parvus({
    l10n: {
      lightboxLabel: 'Dies ist ein Dialogfenster, das den Hauptinhalt der Seite überlagert. Das Modal zeigt das vergrößerte Bild. Durch Drücken der Escape-Taste wird das Modal geschlossen und Sie kehren an die Stelle zurück, an der Sie sich auf der Seite befanden.',
      lightboxLoadingIndicatorLabel: 'Bild wird geladen',
      previousButtonLabel: 'Vorheriges Bild',
      nextButtonLabel: 'Nächstes Bild',
      closeButtonLabel: 'Dialogfenster schließen'
    }
  })

  const swiperContainer = '.carousel'
  document.querySelectorAll(swiperContainer).forEach.call(document.querySelectorAll(swiperContainer), function (carousel, index, arr) {
    const slidesPerView = carousel.getAttribute('data-slides-to-show')
    const duration = carousel.getAttribute('data-duration')
    const autoslide = carousel.getAttribute('data-autoslide')

    let carouselOptions = {
      slidesPerView: slidesPerView,

      keyboard: {
        enabled: true
      }
    }

    if (autoslide === '1') {
      carouselOptions.autoplay = {
        duration: duration,
        pauseOnMouseEnter: true
      }
    }

    const swiper = new Swiper('.carousel', carouselOptions)
  })


})
