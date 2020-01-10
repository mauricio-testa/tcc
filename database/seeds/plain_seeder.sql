php artisan migrate:fresh

use laravel;

SET FOREIGN_KEY_CHECKS=0;

insert into municipios values (4040, 'Liberato Salzano', 'RS');

insert into unidades (id, id_municipio, descricao) values (1, 4040, 'Unidade Teste');

insert into users (id, name, email, password, id_unidade, remember_token) values (1, 'Mauricio', 'mauriciotesta97@gmail.com', '$2y$10$wLXySvcSVR3SFmz6Utzw9e2nUgELOmbxhNBjW//vOyC3Vrh35vxaO', '1', NULL);

insert into motoristas (nome, id_unidade) values ('Motorista 1', 1);
insert into motoristas (nome, id_unidade) values ('Motorista 2', 1);
insert into motoristas (nome, id_unidade) values ('Motorista 3', 1);
insert into motoristas (nome, telefone, id_unidade) values ('Motorista 4', '(99)99999-9999', 1);
insert into motoristas (nome, telefone, id_unidade) values ('Motorista 5', '(99)99999-9999', 1);

insert into veiculos (id_unidade, descricao, placa, lotacao) values (1, 'Ambulancia', 'IXX8888', '6');
insert into veiculos (id_unidade, descricao, placa, lotacao) values (1, 'Carro', 'IXX8888', '6');
insert into veiculos (id_unidade, descricao, placa, lotacao) values (1, 'Van', 'IXX8888', '6');
insert into veiculos (id_unidade, descricao, placa, lotacao) values (1, 'Onibus', 'IXX8888', '6');
insert into veiculos (id_unidade, descricao, placa, lotacao) values (1, 'Ducato', 'IXX8888', '6');

insert into pacientes (nome, id_unidade, codigo_municipio) values ('Pedro 1', 1, 4040);
insert into pacientes (nome, id_unidade, codigo_municipio) values ('Pedro 2', 1, 4040);
insert into pacientes (nome, id_unidade, codigo_municipio) values ('Pedro 3', 1, 4040);
insert into pacientes (rg, nome, telefone, endereco, id_unidade, codigo_municipio) values ('111111111', 'Pedro 4', '', 'Rua B', 1, 4040);
insert into pacientes (rg, nome, telefone, endereco, id_unidade, codigo_municipio) values ('111111111', 'Pedro 5', '', 'Rua B', 1, 4040);

insert into viagens (id_unidade, id_veiculo, id_motorista, cod_destino, data_viagem, hora_saida) values (1, 1, 1, 4040, '2020/01/01', '00:00:00');
insert into viagens (id_unidade, id_veiculo, id_motorista, cod_destino, data_viagem, hora_saida) values (1, 2, 2, 4040, '2020/01/01', '00:00:00');
insert into viagens (id_unidade, id_veiculo, id_motorista, cod_destino, data_viagem, hora_saida) values (1, 3, 3, 4040, '2020/01/01', '00:00:00');
insert into viagens (id_unidade, id_veiculo, id_motorista, cod_destino, data_viagem, hora_saida, observacao) values (1, 4, 4, 4040, '2020/01/01', '00:00:00', 'Teste 1');
insert into viagens (id_unidade, id_veiculo, id_motorista, cod_destino, data_viagem, hora_saida, observacao) values (1, 5, 5, 4040, '2020/01/01', '00:00:00', 'Teste 1');

SET FOREIGN_KEY_CHECKS=1;