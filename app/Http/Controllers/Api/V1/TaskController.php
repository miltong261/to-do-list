<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskPostRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $records = Task::all();

            return response()->json([
                'success' => true,
                'message' => 'Records',
                'data' => $records
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error getting records',
                'data' => array()
            ], 500);
        }
    }

    /**
     * Display a listing of the deleted resources.
     */
    public function showDeletedRecords()
    {
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();

        try {
            $records = Task::onlyTrashed()
                ->whereBetween('deleted_at', [$startOfDay, $endOfDay])
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Records',
                'data' => $records
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error getting deleted records',
                'data' => array()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskPostRequest $request)
    {
        try {
            $record = Task::create($request->only(
                'name',
                'description'
            ));

            return response()->json([
                'success' => true,
                'message' => 'Created successfully!',
                'data' => $record
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error creating record',
                'data' => null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $record = Task::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Record',
                'data' => $record
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $e->getMessage() : 'Record not found',
                'data' => null
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error getting record',
                'data' => null
            ], 500);
        }
    }

    /**
     * Display the specified deleted resource.
     */
    public function showDeletedRecord(string $id)
    {
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();

        try {
            $records = Task::onlyTrashed()
                ->where('id', $id)
                ->whereBetween('deleted_at', [$startOfDay, $endOfDay])
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'message' => 'Record',
                'data' => $records
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $e->getMessage() : 'Record not found',
                'data' => null
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error getting deleted record',
                'data' => null
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $id)
    {
        try {
            $record = Task::findOrFail($id);

            $record->update($request->only(
                'name',
                'description'
            ));

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully!',
                'data' => $record
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $e->getMessage() : 'Record not found',
                'data' => null
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error updating record',
                'data' => null
            ], 500);
        }
    }

    /**
     * Change status the specified resource from storage.
     */
    public function changeStatus(string $id)
    {
        try {
            $record = Task::findOrFail($id);

            $record->update([
                'status' => !$record->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Record status updating successfully!',
                'data' => $record
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $e->getMessage() : 'Record not found',
                'data' => null
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error updating record status',
                'data' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        try {
            $records = Task::all();

            if ($records->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not records found to delete',
                    'data' => null
                ], 404);
            }

            $records->each->delete();

            return response()->noContent();
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error deleting records',
                'data' => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyById(string $id)
    {
        try {
            $record = Task::findOrFail($id);

            $record->delete();

            return response()->noContent();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $e->getMessage() : 'Record not found',
                'data' => null
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error deleting record',
                'data' => null
            ], 500);
        }
    }

    /**
     * Restore all resources from storage.
     */
    public function restore()
    {
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();

        try {
            $records = Task::onlyTrashed()
                ->whereBetween('deleted_at', [$startOfDay, $endOfDay])
                ->get();

            if ($records->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not records found to restore',
                    'data' => null
                ], 404);
            }

            $records->each->restore();

            return response()->json([
                'success' => true,
                'message' => 'Records restoring successfully!',
                'data' => $records
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error restoring records',
                'data' => null
            ], 500);
        }
    }

    /**
     * Change status the specified deleted resource from storage.
     */
    public function restoreById(string $id)
    {
        try {
            $record = Task::onlyTrashed()->findOrFail($id);

            $record->restore();

            return response()->json([
                'success' => true,
                'message' => 'Record restoring successfully!',
                'data' => $record
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $e->getMessage() : 'Record not found',
                'data' => null
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error restoring record',
                'data' => null
            ], 500);
        }
    }
}
