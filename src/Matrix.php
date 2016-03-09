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
     * The unit system used for calculations
     * @var string $units
     */
    protected $units = 'metric';

    /**
     * The transportation mode used for calculations
     * @var string $mode
     */
    protected $mode = 'driving';


    protected $origins;
    protected $destinations;

    public function __construct($key, $config = [])
    {
        parent::__construct([
            'base_uri' => $this->uri,
            'verify' => false
        ]);

        $this->key = $key;
    }


    /**
     * Set the transportation mode
     * Accepted values : driving|walking|bicycling|transit
     * @param $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Set the unit system
     * Accepted values : metric|imperial
     * @param $units
     */
    public function setUnits($units)
    {
        $this->units = $units;
    }


    /**
     * Gets the travel information between two points
     *
     * @param $origin
     * @param $destination
     * @return MatrixElement
     * @throws MatrixException
     */
    public function compare($origin, $destination)
    {
        $this->addOrigin($origin);
        $this->addDestination($destination);

        $response = $this->call($this->getQueryParameters());

        //@TODO refactor
        $elements = current($response->rows);
        $element = current(current($elements));

        return new MatrixElement($element);
    }

    /**
     * Return the distance in kilometers
     * @param $origin
     * @param $destination
     * @return float
     */
    public function getDistanceBetween($origin, $destination)
    {
        $element = $this->compare($origin, $destination);
        return $element->distance / 1000;
    }

    /**
     * Get the travel time in format of your choice
     * @param $origin
     * @param $destination
     * @param string $format
     * @return bool|string
     */
    public function getDurationBetween($origin, $destination, $format = "H:i:s")
    {
        $element = $this->compare($origin, $destination);
        return date($format, $element->duration);
    }

    /**
     * Make a call to Google Matrix API
     * @param $query
     * @return mixed
     * @throws MatrixException
     */
    protected function call($query)
    {
        $response = $this->request('GET', null, ['query' => $query]);
        $body = json_decode($response->getBody()->getContents());

        if ($body->status != 'OK')
            throw new MatrixException($body->status);

        return $body;
    }

    /**
     * Prepare an array of query string parameters
     * @return array
     */
    protected function getQueryParameters()
    {
        return [
            'origins' => implode('|', $this->origins),
            'destinations' => implode('|', $this->destinations),
            'mode' => $this->mode,
            'units' => $this->units,
            'key' => $this->key
        ];
    }

    protected function addOrigin($origin)
    {
        $this->origins[] = $origin;
    }

    protected function addDestination($destination)
    {
        $this->destinations[] = $destination;
    }




}