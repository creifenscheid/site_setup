window.addEventListener('DOMContentLoaded', (event) => {
  // LIGHTBOX
  initLightbox()

  // CAROUSEL
  initCarousel()
})

function initCarousel () {
  const swiperContainer = '.carousel';
  document.querySelectorAll(swiperContainer).forEach.call(document.querySelectorAll(swiperContainer), function (carousel, index, arr) {
    const slidesPerView = carousel.getAttribute('data-slides-to-show');
    const duration = carousel.getAttribute('data-duration');
    const autoslide = carousel.getAttribute('data-autoslide');

    let carouselOptions = {
      slidesPerView: 1,
      watchSlidesProgress: true,

      breakpoints: {
        700: {
          slidesPerView: slidesPerView
        }
      },

      keyboard: {
        enabled: true
      },

      on: {
        init: function () {
          adjustCarouselElementVisibility(this);
          toggleCarouselControls(this);
        }
      }
    }

    if (autoslide === '1') {
      carouselOptions.autoplay = {
        duration: duration,
        pauseOnMouseEnter: true
      };

    }

    const swiper = new Swiper('.carousel', carouselOptions);
    const carouselId = swiper.el.dataset.carousel;

    swiper.on('slideChange', function () {
      document.getElementById(carouselId + '-prev').removeAttribute('disabled');
      document.getElementById(carouselId + '-next').removeAttribute('disabled');

      if (swiper.isBeginning) {
        document.getElementById(carouselId + '-prev').setAttribute('disabled', true);
      }
      if (swiper.isEnd) {
        document.getElementById(carouselId + '-next').setAttribute('disabled', true);
      }

      adjustCarouselElementVisibility(swiper)
    })

    swiper.on('breakpoint', function () {
      toggleCarouselControls(this);
    })

    // get carousel controller
    const carouselControls = document.getElementById(carouselId + '-controls').querySelectorAll('.js-carousel-action');
    carouselControls.forEach.call(carouselControls, function (actionElement, index, arr) {

      switch (actionElement.dataset.action) {
        case 'prev':

          if (swiper.isBeginning) {
            actionElement.setAttribute('disabled', true);
          }

          actionElement.addEventListener('click', function () {
            swiper.slidePrev();

            if (swiper.isBeginning) {
              document.getElementById(carouselId + '-next').focus();
            }
          })

          break;

        case 'play':

          if (swiper.autoplay.running) {
            actionElement.setAttribute('disabled', true);
          }

          actionElement.addEventListener('click', function () {
            swiper.autoplay.start();

            // disable play
            actionElement.setAttribute('disabled', true);
            // enable stop
            document.getElementById(carouselId + '-stop').removeAttribute('disabled');
            document.getElementById(carouselId + '-stop').focus();
          })

          break;

        case 'stop':

          if (swiper.autoplay.paused) {
            actionElement.setAttribute('disabled', true);
          }

          actionElement.addEventListener('click', function () {
            swiper.autoplay.stop();

            // disable stop
            actionElement.setAttribute('disabled', true);
            // enable stop
            document.getElementById(carouselId + '-play').removeAttribute('disabled');
            document.getElementById(carouselId + '-play').focus();
          })

          break;

        case 'next':

          if (swiper.isEnd) {
            actionElement.setAttribute('disabled', true);
          }

          actionElement.addEventListener('click', function () {
            swiper.slideNext();

            if (swiper.isEnd) {
              document.getElementById(carouselId + '-prev').focus();
            }
          })

          break;
      }
    })
  })
}

function adjustCarouselElementVisibility(swiper) {
  swiper.slides.forEach.call(swiper.slides, function (slide, index, arr) {
    if (slide.classList.contains('swiper-slide-visible')) {
      slide.removeAttribute('aria-hidden');
    } else {
      slide.setAttribute('aria-hidden', true);
    }
  })
}

function toggleCarouselControls(swiper)
{
  const carouselId = swiper.el.dataset.carousel;
  let carouselControls = document.getElementById(carouselId + '-controls');

  if (!swiper.isLocked || (swiper.allowSlidePrev === false && swiper.allowSlideNext === false)) {
    carouselControls.style.display = 'none';
  } else {
    carouselControls.removeAttribute('style');
  }
}

function initLightbox () {
  // @SeppToDo localization
  const prvs = new Parvus({
    l10n: {
      lightboxLabel: 'Dies ist ein Dialogfenster, das den Hauptinhalt der Seite überlagert. Das Modal zeigt das vergrößerte Bild. Durch Drücken der Escape-Taste wird das Modal geschlossen und Sie kehren an die Stelle zurück, an der Sie sich auf der Seite befanden.',
      lightboxLoadingIndicatorLabel: 'Bild wird geladen',
      previousButtonLabel: 'Vorheriges Bild',
      nextButtonLabel: 'Nächstes Bild',
      closeButtonLabel: 'Dialogfenster schließen'
    }
  });
}
