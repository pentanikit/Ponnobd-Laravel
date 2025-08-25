<?php

namespace App\Livewire\Frontend\Customer;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MyProfile extends Component
{
    use WithFileUploads;

    public $user;

    public $email;

    public $name;

    public $mobile;

    public $profile_pic;

    public $current_password;

    public $new_password;

    public $password_confirmation;

    public function mount()
    {
        $this->user = auth()->user();
        $this->email = user('email');
        $this->name = user('name');
        $this->mobile = user('phone');
    }

    public function updateProfile()
    {
        $this->validate([
            'email' => 'nullable|email|unique:users,email,'.$this->user->id,
            'name' => 'required',
            'mobile' => 'nullable|min:11|unique:users,phone,'.$this->user->phone,
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $user = User::find(auth()->id());
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->mobile;
        if ($this->profile_pic) {

            $imageName = time().'.'.$this->profile_pic->getClientOriginalExtension();
            $profile_pic = $this->profile_pic->storeAs($this->user->id, $imageName, 'profile_pic');
            $user->profile_pic = 'uploads/profile_pic/'.$profile_pic;
        }

        $user->save();
        $this->user = auth()->user();
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Profile has been updated!',
        ]);
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password',
        ]);

        $user = User::find(auth()->id());

        if (Hash::check($this->current_password, $user->password)) {
            $user->password = $this->new_password;
            $user->save();

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Password has been changed!',
            ]);
        } else {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Current password is wrong!',
            ]);
        }

        $this->reset(['new_password', 'current_password', 'password_confirmation']);

    }

    #[Title('My Profile')]
    public function render()
    {
        return view('livewire.frontend.customer.my-profile');
    }
}
