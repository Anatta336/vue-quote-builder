<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller for the single page application front end.
 *
 * @package FrontEnd
 */
class SpaController extends Controller
{
    public function index()
    {
        return view('spa');
    }
}
