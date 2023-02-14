<?php


class Furniture extends Product
{
    private $length;

    private $width;

    private $height;

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height): void
    {
        $this->height = Sanitizer::sanitize($height);
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length): void
    {
        $this->length = Sanitizer::sanitize($length);
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width): void
    {
        $this->width = Sanitizer::sanitize($width);
    }

    function getType()
    {
        return "FURNITURE";
    }

    function create(): bool
    {
        $query = 'INSERT INTO ' . $this->getTableName() . ' SET sku = :sku, name = :name, price = :price, type= :type, height = :height, width= :width, length= :length';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $successful = $stmt->execute([
            ":sku" => $this->getSku(),
            ":name" => $this->getName(),
            ":price" => $this->getPrice(),
            ":type" => $this->getType(),
            ":width" => $this->getWidth(),
            ":height" => $this->getHeight(),
            ":length" => $this->getLength(),
        ]);

        // Execute query
        if ($successful) {
            return true;
        }
        return false;
    }

    public function toArray(): array
    {
        $from_parent = parent::toArray();
        $from_parent["length"] = $this->getLength();
        $from_parent["width"] = $this->getWidth();
        $from_parent["height"] = $this->getHeight();
        return $from_parent;
    }

}