USE instruct;

CREATE TABLE services (
	ref VARCHAR(11) NOT NULL,
    centre VARCHAR(255),
    service VARCHAR(255),
    country CHAR(2),
    PRIMARY KEY(ref)
);