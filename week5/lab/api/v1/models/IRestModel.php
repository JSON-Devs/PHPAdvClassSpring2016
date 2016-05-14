<?php

/**
 *
 * @author GFORTI
 */
interface IRestModel {
    //put your code here
    function getAll();
    function get($id); 
    function post($serverData);
    function put($id, $serverData);
    function delete($id);
}
