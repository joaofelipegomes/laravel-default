<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DatabaseQueries;
use Carbon\Carbon;

class CollaboratorController extends Controller
{
  public function punchedClock(Request $request)
  {
    $__display = 100;
    $resultsArray = [];
    $amount_total = 0;

    $collaborator = ($request->colaborador) ? $request->colaborador : 12;
    $start_date = ($request->inicio) ? $request->inicio : dateFormat(Carbon::now()->startOfMonth());
    $end_date = ($request->fim) ? $request->fim : dateFormat(Carbon::now());

    $db = new DatabaseQueries();

    $users = $db->users();
    $punchedClock = $db->getPunchedClock($collaborator, $start_date, $end_date);

    foreach ($punchedClock as $row) {
      if (!empty($row)) {
        if ($row->end) {
          $start_date_formated = Carbon::parse($row->start);
          $end_date_formated = Carbon::parse($row->end);

          $amount = $end_date_formated->diffInSeconds($start_date_formated);
          $amount_total = $amount_total + $amount;

          $resultsArray[] = array(
            'id' => $row->id,
            'name' => $row->name,
            'start' => $row->start,
            'end' => $row->end,
            'company' => $row->company,
            'duration' => $start_date_formated->diff($end_date_formated)->format('%H:%I:%S'),
            'amount' => moneyFormat($amount * 0.0052)
          );
        } else {
          $resultsArray[] = array(
            'id' => $row->id,
            'name' => $row->name,
            'start' => $row->start,
            'end' => '',
            'company' => $row->company,
            'duration' => '00:00:00',
            'amount' => '0,00'
          );
        }
      }
    }

    $numberOfRowsDisplayed = (count($punchedClock) < $__display) ? count($punchedClock) : $__display;
    $numberOfRows = count($punchedClock);

    return view('admin.collaborator.punchedclock.index')
      ->with('start_date', $start_date)
      ->with('end_date', $end_date)
      ->with('users', $users)
      ->with('collaborator', $collaborator)
      ->with('punched_clock', array_slice($resultsArray, 0, $__display))
      ->with('amount', moneyFormat($amount_total * 0.0052))
      ->with('total_hours', format_time($amount_total))
      ->with('number_of_rows_displayed', $numberOfRowsDisplayed)
      ->with('number_of_rows', $numberOfRows);
  }

  public function vacationEdit($id)
  {
    $db = new DatabaseQueries();
    $users = $db->users();
    $vacation = $db->vacation($id);

    return view('admin.collaborator.vacation.create.index')
      ->with('id', $id)
      ->with('users', $users)
      ->with('vacation', $vacation);
  }

  public function vacationCreate()
  {
    $db = new DatabaseQueries();
    $users = $db->users();

    return view('admin.collaborator.vacation.create.index')
      ->with('users', $users);
  }

  public function vacation(Request $request)
  {
    $__display = 50;
    $resultsArray = [];
    $search = ($request->busca) ? $request->busca : null;
    $collaborator = ($request->colaborador) ? $request->colaborador : null;

    $db = new DatabaseQueries();
    $users = $db->users();

    if ($collaborator) {
      $user = $db->user($collaborator);
      $user_name = $user[0]->name;
    } else {
      $user_name = '';
    }

    $vacations = $db->vacations($search, $user_name);

    foreach ($vacations as $row) {
      $resultsArray[] = (array) $row;
    }

    $numberOfRowsDisplayed = (count($vacations) < $__display) ? count($vacations) : $__display;
    $numberOfRows = count($vacations);

    return view('admin.collaborator.vacation.index')
      ->with('search', $search)
      ->with('collaborator', $collaborator)
      ->with('users', $users)
      ->with('vacations', array_slice($resultsArray, 0, $__display))
      ->with('number_of_rows_displayed', $numberOfRowsDisplayed)
      ->with('number_of_rows', $numberOfRows);
  }
}
