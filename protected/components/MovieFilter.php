<?php

/**
 * Class MovieFilter
 */
class MovieFilter extends CApplicationComponent
{
    /**
     * @var StdClass
     */
    private $_dataObj;

    /**
     * Retrieves movies data object
     * @param $params
     */
    public function load($params)
    {
        $client = new \TmApi\Client(Yii::app()->user->identity->apiKey);
        $discover = new \TmApi\Rest\Discover($client);
        $this->_dataObj = $discover->movie($params);
    }

    /**
     * Builds data provider based on retrieved data
     * @return CArrayDataProvider
     * @throws Exception
     */
    public function getDataProvider()
    {
        return new CArrayDataProvider($this->getOption('results'), array(
            'id' => 'movies',
            'sort' => false,
            'pagination' => false,
        ));
    }

    public function getOption($name)
    {
        if($this->_dataObj === null) {
            throw new Exception(Yii::t('app', "Movies data not loaded."));
        }
        if(!property_exists($this->_dataObj, $name)) {
            throw new Exception(Yii::t('app', "Property \"{$name}\" doesn't exist in Movies data."));
        }
        return $this->_dataObj->$name;
    }

}