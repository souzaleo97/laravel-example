<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Support\Collection;

class NoteRepository extends BaseRepository
{
    public function all(Collection $params)
    {
        $notes = Note::when($params->get('user_id'), function ($q) use (
            $params
        ) {
            return $q->where('user_id', $params->get('user_id'));
        });

        return $this->paginate($notes, $params);
    }

    public function store($data)
    {
        $note = new Note();
        $note->fill($data);
        $note->save();

        return $note->getKey();
    }

    public function findById($id)
    {
        $note = Note::find($id);

        if ($note) {
            return $note->toArray();
        }

        return null;
    }

    public function update($data, $id)
    {
        $note = Note::find($id);

        $note->fill($data);
        $note->update();

        return $note->getKey();
    }

    public function delete($id)
    {
        $note = Note::find($id);
        $note->delete();

        return true;
    }
}
