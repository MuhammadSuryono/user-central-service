<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserBankAccount;
use App\Models\UserDetail;
use App\Models\UserDocument;
use App\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Controller implements Interfaces\UserInterface
{

    /**
     * @inheritDoc
     */
    public function list_users(): object
    {
        $users = User::paginate($this->getLimit());
        UserResource::collection($users);
        return $this->callback(true, "Success retrieve data", $users);
    }

    /**
     * @return object
     */
    public function create_user(): object
    {
        $user = new User();
        foreach ($this->request->all() as $key => $value) {
            if ($key == 'password') {
                $user->$key = Hash::make($value);
            } else {
                $user->$key = $value;
            }
        }
        $isSaved = $user->save();
        return $this->callback($isSaved, $isSaved ? "Success create data":"Failed create data", $user);
    }


    /**
     * @inheritDoc
     */
    public function update_user(int $id): object
    {
        $user = User::find($id);
        if ($user == null) return $this->callback(false, "Data not found");

        foreach ($this->request->all() as $key => $value) {
            $user->$key = $value;
        }
        $isSaved = $user->save();
        return $this->callback($isSaved, $isSaved ? "Success update data":"Failed update data", $user);
    }

    /**
     * @inheritDoc
     */
    public function delete_user(int $id): object
    {
        $user = User::find($id);
        if ($user == null) return $this->callback(false, "Data not found");

        $isDeleted = $this->delete_data_user($user);
        return $this->callback($isDeleted, $isDeleted ? "Success delete data":"Failed delete data", $user);
    }

    /**
     * @param User $user
     * @return bool|null
     */
    private function delete_data_user(User $user): ?bool
    {
        $isDeleted = $user->delete();

        $dataDetail = UserDetail::where('user_id', $user->id)->first();
        if ($dataDetail != null) {
            $isDeleted = $dataDetail->delete();
        }

        $dataBank = UserBankAccount::where('user_id', $user->id)->first();
        if ($dataBank != null) {
            $isDeleted = $dataBank->delete();
        }

        $dataDocument = UserDocument::where('user_id', $user->id)->first();
        if ($dataDocument != null) {
            $isDeleted = $dataDocument->delete();
        }

        return $isDeleted;
    }

    /**
     * @inheritDoc
     */
    public function add_detail_user(int $id): object
    {
        $user = User::find($id);
        if ($user == null) return $this->callback(false, "Data not found");

        $detail = UserDetail::where('user_id', $user->id)->first();
        if ($detail == null) {
            $detail = new UserDetail();
            $detail->user_id = $user->id;
        }
        foreach ($this->request->all() as $key => $value) {
            $detail->$key = $value;
        }
        $isSaved = $detail->save();
        return $this->callback($isSaved, $isSaved ? "Success create data":"Failed create data", $detail);
    }

    /**
     * @inheritDoc
     */
    public function add_bank_account(int $id): object
    {
        $user = User::find($id);
        if ($user == null) return $this->callback(false, "Data not found");

        $userBank = new UserBankAccount();
        $userBank->user_id = $user->id;
        foreach ($this->request->all() as $key => $value) {
            $userBank->$key = $value;
        }
        $isSaved = $userBank->save();
        return $this->callback($isSaved, $isSaved ? "Success create data":"Failed create data", $userBank);
    }

    /**
     * @inheritDoc
     */
    public function add_document(int $id): object
    {
        // TODO: Implement add_document() method.
    }

    /**
     * @inheritDoc
     */
    public function update_bank_account(int $bankAccountId): object
    {
        $userBank = UserBankAccount::find($bankAccountId);
        if ($userBank == null) return $this->callback(false, "Data not found");

        foreach ($this->request->all() as $key => $value) {
            $userBank->$key = $value;
        }
        $isSaved = $userBank->save();
        return $this->callback($isSaved, $isSaved ? "Success update data":"Failed update data", $userBank);
    }

    /**
     * @inheritDoc
     */
    public function delete_bank_account(int $bankAccountId): object
    {
        $userBank = UserBankAccount::find($bankAccountId);
        if ($userBank == null) return $this->callback(false, "Data not found");

        $isDeleted = $userBank->delete();
        return $this->callback($isDeleted, $isDeleted ? "Success delete data":"Failed delete data", $userBank);
    }
}
