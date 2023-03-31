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

    const swiper = new Swiper('.carousel', {
      direction: 'vertical',
      loop: true,

      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    })
});
