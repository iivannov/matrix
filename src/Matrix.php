<?php

namespace Iivannov\Matrix;

use GuzzleHttp\Client;

class Matrix extends Client
{

    /**
     * Google Matrix API base URI
     * @see https://developers.google.com/maps/documentation/distance-matrix/intro#DistanceMatrixRequests
     * @var string
     */
    protected $uri = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    /**
     * Google API authorization key
     * @var string
     */
    protected $key;

    /**
     * The unit system used for calculations, metric by default
     * @var string metric|imperial
     */
    protected $units = 'metric';


    public function __construct($key, $config = [])
    {
        parent::__construct([
            'base_uri' => $this->uri,
            'verify' => false
        ]);

        $this->key = $key;
    }


    public function call()
    {
        $response = $this->request('GET');
        return $response->getBody()->getContents();
    }




}