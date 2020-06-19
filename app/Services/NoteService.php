<?php

namespace App\Services;

use App\Repositories\NoteRepository;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoteService
{
    protected $note;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->note = $noteRepository;
    }

    public function index(Collection $params)
    {
        return $this->note->all($params);
    }

    public function store($data)
    {
        $id = DB::transaction(function () use ($data) {
            $id = $this->note->store($data);

            return $id;
        });

        return $this->note->findById($id);
    }

    public function show($id)
    {
        $note = $this->note->findById($id);

        if ($note['user_id'] !== Auth::id()) {
            throw new Exception(__('errors.note_not_access'));
        }

        return $note;
    }

    public function update($data, $id)
    {
        $id = DB::transaction(function () use ($data, $id) {
            $note = $this->note->findById($id);

            if (!$note) {
                throw new Exception(__('errors.note_not_found'));
            }

            if ($note['user_id'] !== Auth::id()) {
                throw new Exception(__('errors.note_not_access'));
            }

            return $this->note->update($data, $id);
        });

        return $this->note->findById($id);
    }

    public function delete($id)
    {
        $note = $this->note->findById($id);

        if (!$note) {
            throw new Exception(__('errors.note_not_found'));
        }

        if ($note['user_id'] !== Auth::id()) {
            throw new Exception(__('errors.note_not_access'));
        }

        return $this->note->delete($id);
    }
}
