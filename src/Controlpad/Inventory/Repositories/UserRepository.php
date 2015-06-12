<?php namespace Controlpad\Inventory\Repositories;

interface IUserRepository {
   
  public function all();
 
  public function find($id);
 
  public function create($input);
 
}
?>
