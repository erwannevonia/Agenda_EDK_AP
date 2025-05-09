<?php

require __DIR__ . '/vendor/autoload.php';

\Sentry\init(['dsn' => 'http://ab62b5fb0837424aa4b3a9290c4daa6a@172.16.0.100:8000/1' ]);

// try {
//     throw new Exception("[EDK] Erreur d'accueil de la parole divine (skill diff) Erwann et ManoMano.fr service après-vente");
// } catch (Exception $e) {
//     \Sentry\captureException($e);
// }

// \Sentry\captureMessage("");

?>