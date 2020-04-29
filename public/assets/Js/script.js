const options = {
    // Obligatoire: clé API
    key: 'h0NUA56jVxXfBxUIyfpFAWIidYAf52Tx',  // REMPLACEZ AVEC VOTRE CLÉ !!!

    // Mettre une sortie console supplémentaire
    verbose: true,

    // Facultatif: état initial de la carte
    lat: 50.4,
    lon: 14.3,
    zoom: 5,
};

// Initialiser l'API Windy
windyInit(options, windyAPI => {
    // windyAPI est prêt et contient 'map', 'store',
    // 'picker' et autres trucs utiles

    const { map } = windyAPI;
    // .map est une instance de Leaflet map

    // L.popup()
    //     .setLatLng([50.4, 14.3])
    //     .setContent('Hello World')
    //     .openOn(map);
    L.popup()
        .setLatLng([ 48.858370, 2.294481])
        .setContent('Voyageons à Paris')
        .openOn(map);
});
console.log('test');