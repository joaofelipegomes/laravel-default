<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DatabaseQueries;
use Illuminate\Http\Request;

class PanelController extends Controller
{
  public function favorites()
  {
    return view('admin.panel.favorites.index');
  }

  public function welcome()
  {
    $db = new DatabaseQueries();
    $countDelayedPayments = $db->countDelayedPayments();

    return view('admin.panel.index')
    ->with([
      'count_delayed_payments' => $countDelayedPayments[0]->count,
    ]);
  }
}
