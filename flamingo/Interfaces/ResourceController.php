<?php

namespace Flamingo\Interfaces;


interface ResourceController
{
    /**
     * Index GET method.
     *
     * Index method is a default GET method.
     * It is the default page which shows
     * when specific url is called with GET request.
     *
     * @return mixed
     */
    public function index();

    /**
     * Create GET method.
     *
     * This is registered as GET method.
     * Create method is used for data
     * which you want to upload onto
     * the database. For example: forms.
     *
     * @return mixed
     */
    public function create();

    /**
     * Store POST method.
     *
     * This method is called whether
     * data has been passed from create
     * method. All the data are being
     * handled by this method.
     *
     * @return mixed
     */
    public function store();

    /**
     * Show GET method.
     *
     * This method is used for showing
     * specific data from table based
     * on id parameter.
     *
     * @param $id
     * @return mixed
     */
    public function show($id);

    /**
     * Edit GET method.
     *
     * This method is similar to create
     * but with the small change, that
     * we are handling edit form to edit
     * things inside database.
     *
     * @param $id
     * @return mixed
     */
    public function edit($id);

    /**
     * Update PUT method.
     *
     * This method PUTs edited data
     * into database.
     *
     * @param $id
     * @return mixed
     */
    public function update($id);

    /**
     * Destroy DELETE method.
     *
     * This method destroys a data
     * inside database.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id);
}