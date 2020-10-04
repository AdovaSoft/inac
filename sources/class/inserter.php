<?php


/**
 * Class inserter
 */
class inserter
{
    /**
     * @var null
     */
    protected $tableName = null;
    protected $colums = array();
    protected $values = array();
    protected $flag = array();

    /**
     * @param $par_id
     * @param $value
     */
    public function set_parameter($par_id, $value)
    {
        switch ($par_id) {
            case 1:
                $this->tableName = $value;
                break;
            case 2:
                $this->colums = $value;
                break;
            case 3:
                $this->values = $value;
                break;
            case 4:
                $this->flag = $value;
                break;
            default :
                echo "Action Failed!";
        }
    }

    /**
     *
     */
    public function reset_parameter()
    {
        unset($this->colums);
        unset($this->flag);
        unset($this->values);
        unset($this->tableName);
    }

    /**
     * @param $sQ
     * @return mixed
     */
    public function Insert($sQ)
    {
        return $sQ->insert_query($this->tableName, $this->colums, $this->values, $this->flag);
    }
}
