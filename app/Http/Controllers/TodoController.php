<?php

namespace App\Http\Controllers;

use App\Jobs\SendReminder;
use App\Models\TodoItem;
use App\Models\TodoList;
use App\repo\TodoItemRepository;
use App\repo\TodoListRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class TodoController extends Controller
{
    protected $todo_list_repo;
    protected $todo_item_repo;

    public function __construct(TodoListRepository $todoListRepository, TodoItemRepository $todoItemRepository)
    {
        $this->middleware('auth:sanctum');
        $this->todo_list_repo = $todoListRepository;
        $this->todo_item_repo = $todoItemRepository;
    }

    public function saveList(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'description' => 'required',
        ]);

        if ($validator->fails()){
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $user = Auth::user();

        $todo_list = new TodoList();
        $todo_list->description = $input['description'];
        $todo_list->created_by = $user->id;
        $todo_list->updated_by = $user->id;
        $todo_list->save();

        $response = [
            'success' => true,
            'message' => 'ToDo List Saved Successfully!'
        ];

        return response()->json($response,200);
    }

    public function getAllTodoLists()
    {
        $user = Auth::user();
        $lists = $this->todo_list_repo->findBy(['created_by' => $user->id]);
        return response()->json($lists);
    }

    public function saveTodoItem(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'item_description' => 'required',
            'due_date' => 'required',
            'due_time' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response,400);
        }

        $input = $request->all();
        $user = Auth::user();

        $todo_item = new TodoItem();
        $todo_item->todo_list_id = $input['todo_list_id']; // Set the relationship to the td list
        $todo_item->item_description = $input['item_description'];
        $todo_item->due_date = $input['due_date'];
        $todo_item->due_time = $input['due_time'];
        $todo_item->status = 1;
        $todo_item->created_by = $user['id'];
        $todo_item->updated_by = $user['id'];
        $todo_item->save();

        $due_date = $todo_item->due_date;
        $due_time = $todo_item->due_time;

        $due_date = date_format(new \DateTime($due_date),"Y-m-d");
        $due_time = date_format(new \DateTime($due_time),"H:i:s");

        $combined_time = $due_date.' '.$due_time;
        $combined_time = date_format(new \DateTime($combined_time),"Y-m-d H:i:s");

        $before_one_hour = date("Y-m-d H:i:s", strtotime($combined_time. ' -1 hours'));
        $before_one_hour = date_format(new \DateTime($before_one_hour),"Y-m-d H:i:s");
        $before_one_hour = Carbon::parse($before_one_hour);

        //$user = Auth::user();

        $data = array(
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'item_description' => $todo_item->item_description
        );

        SendReminder::dispatch($data)->delay($before_one_hour);

        $response = [
            'success' => true,
            'message' => 'ToDo Item Saved Successfully!',
            'reminder_time' => $before_one_hour
        ];

        return response()->json($response,200);

    }

    public function loadTodoItems(Request $request)
    {
        $user = Auth::user();

        $todo_pending_items = $this->todo_item_repo->getPendingItems($request->list_id,$user->id);

        $todo_completed_items = $this->todo_item_repo->getCompletedItems($request->list_id,$user->id);

        $todo_items = array_merge($todo_pending_items, $todo_completed_items);

        return response()->json($todo_items);
    }

    public function completeTask(Request $request)
    {
        $todo_item = $this->todo_item_repo->find($request->item_id);
        $todo_item->completed_at = date("Y-m-d H:i:s");
        $todo_item->status = 2; // Completetd status
        $todo_item->save();

        $response = [
            'success' => true,
            'message' => 'ToDo Item Completed Successfully!'
        ];

        return response()->json($response,200);

    }

    public function deleteTask(Request $request)
    {
        $todo_item = $this->todo_item_repo->find($request->item_id);
        $todo_item->status = 0;
        $todo_item->save();

        $response = [
            'success' => true,
            'message' => 'ToDo Item Deleted Successfully!'
        ];

        return response()->json($response,200);
    }

    public function loadTodoItemDetails($id)
    {
        $todo_item = $this->todo_item_repo->find($id);
        return response()->json($todo_item);

    }

    public function updateTask(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'item_description' => 'required',
            'due_date' => 'required',
            'due_time' => 'required'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response,400);
        }

        $todo_item = $this->todo_item_repo->find($request->id);
        $todo_item->item_description = $request->item_description;
        $todo_item->due_date = $request->due_date;
        $todo_item->due_time = $request->due_time;
        $todo_item->save();

        $due_date = $todo_item->due_date;
        $due_time = $todo_item->due_time;

        $due_date = date_format(new \DateTime($due_date),"Y-m-d");
        $due_time = date_format(new \DateTime($due_time),"H:i:s");

        $combined_time = $due_date.' '.$due_time;
        $combined_time = date_format(new \DateTime($combined_time),"Y-m-d H:i:s");

        $before_one_hour = date("Y-m-d H:i:s", strtotime($combined_time. ' -1 hours'));
        $before_one_hour = date_format(new \DateTime($before_one_hour),"Y-m-d H:i:s");
        $before_one_hour = Carbon::parse($before_one_hour);

        $user = Auth::user();

        $data = array(
            'email' => $user['email'],
            'first_name' => $user['first_name'],
            'item_description' => $todo_item->item_description
        );

        SendReminder::dispatch($data)->delay($before_one_hour);

        $response = [
            'success' => true,
            'message' => 'ToDo Item Updated Successfully!'
        ];

        return response()->json($response,200);
    }
}
