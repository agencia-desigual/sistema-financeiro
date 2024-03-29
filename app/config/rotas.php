<?php

// Erro 404
$Rotas->onError("404", "Principal::error404");


/**
 *  ===========================================================
 *                          ROTAS DA API
 *  ===========================================================
 */


// Usuário
$Rotas->group("api-usuario","api/usuario","Api\Usuario");
$Rotas->onGroup("api-usuario","POST","login","login");
$Rotas->onGroup("api-usuario","POST","insert","insert");
$Rotas->onGroup("api-usuario","POST","update/{p}","update");
$Rotas->onGroup("api-usuario","DELETE","delete/{p}","delete");


// Categoria
$Rotas->group("api-categoria","api/categoria","Api\Categoria");
$Rotas->onGroup("api-categoria","POST","insert","insert");
$Rotas->onGroup("api-categoria","POST","update/{p}","update");
$Rotas->onGroup("api-categoria","DELETE","delete/{p}","delete");


// Movimentacao
$Rotas->group("api-movimentacao","api/movimentacao","Api\Movimentacao");
$Rotas->onGroup("api-movimentacao","POST","insert","insert");
$Rotas->onGroup("api-movimentacao","POST","update/{p}","update");
$Rotas->onGroup("api-movimentacao","DELETE","delete/{p}","delete");


// Movimentacao
$Rotas->group("api-grafico","api/grafico","Api\Grafico");
$Rotas->onGroup("api-grafico","GET","meses","graficoMes");
$Rotas->onGroup("api-grafico","GET","meses/{p}","graficoMes");



/**
 *  ===========================================================
 *                        ROTAS DO SISTEMA
 *  ===========================================================
 */


// Dashboard e Login
$Rotas->on("GET","","Principal::dashboard");
$Rotas->on("GET","login","Principal::login");

// Usuarios
$Rotas->on("GET","usuarios","Usuarios::listar");
$Rotas->on("GET","usuario/adicionar","Usuarios::adicionar");
$Rotas->on("GET","usuario/editar/{p}","Usuarios::editar");

// Categoria
$Rotas->on("GET","categorias","Categorias::listar");
$Rotas->on("GET","categoria/adicionar","Categorias::adicionar");
$Rotas->on("GET","categoria/editar/{p}","Categorias::editar");


// Movimentações
$Rotas->on("GET","movimentacoes/{p}","Movimentacao::listar");
$Rotas->on("GET","movimentacoes","Movimentacao::listar");
$Rotas->on("GET","movimentacao/adicionar","Movimentacao::adicionar");
$Rotas->on("GET","movimentacao/editar/{p}","Movimentacao::editar");

// Sair
$Rotas->on("GET","sair","Principal::sair");