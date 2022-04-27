CREATE TABLE pix_aplicacao(
    id INTEGER NOT NULL,
    nome VARCHAR(60) NOT NULL,
    app_cod VARCHAR(20) NOT NULL,
	app_key VARCHAR(50) NOT NULL,
    access_token VARCHAR(1000),
	access_token_expiracao DATETIME,
    PRIMARY KEY(id)
);

INSERT INTO pix_aplicacao(id, nome, app_cod, app_key)
    VALUES(1, 'Pix Client', 'APP_0996051650033447', '0516D7417F48E15E54B0F94B2E04B495');

CREATE TABLE pix_recebedores(
    id INTEGER NOT NULL,
    nome VARCHAR(60) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO pix_recebedores(id, nome)
    VALUES(1, 'Renato Rodrigues');

