-- PostgreSQL Example Database

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET search_path = public, pg_catalog;
SET default_tablespace = '';
SET default_with_oids = false;

CREATE TABLE test (
    test_id integer NOT NULL,
    name character varying(255),
    params character varying(255)
);

ALTER TABLE public.test OWNER TO postgres;

CREATE SEQUENCE test_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.test_id_seq OWNER TO postgres;


ALTER SEQUENCE test_id_seq OWNED BY test.test_id;

SELECT pg_catalog.setval('test_id_seq', 3, true);

COPY test (test_id, name, params) FROM stdin;
1	test	test_params
2	test2	test2_params
3	test3	test3_params
\.

ALTER TABLE ONLY test ALTER COLUMN test_id SET DEFAULT nextval('test_id_seq'::regclass);

ALTER TABLE ONLY test
    ADD CONSTRAINT test_pkey PRIMARY KEY (test_id);



