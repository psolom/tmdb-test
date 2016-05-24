<?php
/**
 * Class CookieHandler
 */
class CookieHandler extends CApplicationComponent
{
    public $name;

    /**
     * Retrieves stored cookie value
     * @return array|string
     */
    public function get()
    {
        return isset(Yii::app()->request->cookies[$this->name])
            ? Yii::app()->request->cookies[$this->name]->value
            : null;
    }

    /**
     * Set new cookie
     * @param $value
     * @param $expired
     */
    public function set($value, $expired)
    {
        $cookie = new CHttpCookie($this->name, $value);
        $cookie->expire = $expired;
        Yii::app()->request->cookies[$this->name] = $cookie;
    }
}