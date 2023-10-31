<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class ClientList extends Component
{
    use WithPagination;

    public $name, $email, $password;
    public $user_id;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        return view('livewire.users.client-list',[
            'users' => User::paginate(15)
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->user_id = null;
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => ($this->user_id) ? 'nullable' : 'required',
            'user_id' => 'nullable'
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        $userQuery = User::query();
        if (!empty($validatedData['user_id'])) {
            $user = $userQuery->find($validatedData['user_id']);
            if ($user) {
                $user->update($validatedData);
            }
        } else {
            $userQuery->create($validatedData);
        }

        $this->user_id = null;
        session()->flash('message', 'User Created Successfully.');
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        session()->flash('message', 'User Deleted Successfully.');
    }
}
