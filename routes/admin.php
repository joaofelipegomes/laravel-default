<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsLogged;
use App\Http\Middleware\EnsureUserIsValid;
use App\Http\Controllers\Admin\ActivationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CollaboratorController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\StoreController;

Route::middleware(EnsureUserIsLogged::class)->get(
  '/',
  [AuthController::class, 'redirectUser']
);

Route::middleware(EnsureUserIsLogged::class)->get(
  '/entrar',
  [AuthController::class, 'userLoggin']
);

Route::get(
  '/painel',
  [PanelController::class, 'welcome']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/lojas',
  [StoreController::class, 'stores']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/lojas/{id}/detalhes',
  [StoreController::class, 'storeDetails']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/lojas/criar',
  [StoreController::class, 'storeCreate']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/ativacao',
  [ActivationController::class, 'activation']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/favoritos',
  [PanelController::class, 'favorites']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/ativacao/rapida',
  [ActivationController::class, 'activationQuick']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/ativacao/loja/criar',
  [ActivationController::class, 'storeCreate']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/ativacao/loja/{id}',
  [ActivationController::class, 'storeDetails']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/ativacao/loja/{id}/estacao/{station}',
  [ActivationController::class, 'storeStation']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/ativacao/loja/{id}/estacao',
  [ActivationController::class, 'storeWithoutStation']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/colaborador/ferias',
  [CollaboratorController::class, 'vacation']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/colaborador/ferias/criar',
  [CollaboratorController::class, 'vacationCreate']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/colaborador/ferias/editar/{id}',
  [CollaboratorController::class, 'vacationEdit']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/ativacao/loja/{id}/vincular',
  [ActivationController::class, 'storeLinkedStores']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/colaborador/ponto',
  [CollaboratorController::class, 'punchedClock']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/empresa',
  [CompanyController::class, 'companyData']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/modulos',
  [ModuleController::class, 'modules']
);

Route::middleware(EnsureUserIsValid::class)->get(
  '/sair',
  [AuthController::class, 'userLogout']
);
