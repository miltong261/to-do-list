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
     * Retrieves all records from the Task model.
     *
     * This method retrieves all records from the Task model. If records are found, a JSON response
     * with the records is returned. In case of an error during retrieval, a 500 response is returned.
     *
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the retrieval operation.
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
     * Retrieves all soft-deleted records that were deleted within the current day.
     *
     * This method retrieves all soft-deleted records from the Task model that were deleted within
     * the current day. If records are found, a JSON response with the records is returned.
     * In case of an error during retrieval, a 500 response is returned.
     *
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the retrieval operation.
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
     * Creates a new record with the provided data.
     *
     * This method attempts to create a new record using the data provided in the request.
     * The request data is validated by the TaskPostRequest class. If the record is created
     * successfully, a JSON response with the created record is returned with a 201 status code.
     * In case of an error during creation, a 500 response is returned.
     *
     * @param \App\Http\Requests\TaskPostRequest $request The request object containing validated data for creating the record.
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the creation operation.
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
     * Retrieves a record by its ID.
     *
     * This method attempts to find a record by its ID. If the record is found, a JSON response
     * with the record data is returned. If the record is not found, a 404 response is returned.
     * In case of an error during retrieval, a 500 response is returned.
     *
     * @param string $id The ID of the record to retrieve.
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the operation.
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
     * Retrieves a soft-deleted record by its ID if it was deleted within the current day.
     *
     * This method attempts to find a soft-deleted record by its ID that was deleted within the current day.
     * If the record is not found, a 404 response is returned. If the record is found, a JSON response
     * with the record data is returned. In case of an error during the retrieval, a 500 response is returned.
     *
     * @param string $id The ID of the soft-deleted record to retrieve.
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the operation.
     */
    public function showDeletedRecord(string $id)
    {
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();

        try {
            $record = Task::onlyTrashed()
                ->where('id', $id)
                ->whereBetween('deleted_at', [$startOfDay, $endOfDay])
                ->firstOrFail();

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
                'message' => env('APP_DEBUG') ? $th->getMessage() : 'Error getting deleted record',
                'data' => null
            ], 500);
        }
    }

    /**
     * Updates a record by its ID with the provided data.
     *
     * This method attempts to find a record by its ID and update it with the data provided in the
     * request. The request data is validated by the TaskUpdateRequest class. If the record is not found,
     * a 404 response is returned. If the update is successful, a JSON response with the updated record
     * is returned. In case of an error during the update, a 500 response is returned.
     *
     * @param \App\Http\Requests\TaskUpdateRequest $request The request object containing validated data.
     * @param string $id The ID of the record to be updated.
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the operation.
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
     * Toggles the status of a record by its ID.
     *
     * This method attempts to find a record by its ID and toggles its status (e.g., from true to false or vice versa).
     * If the record is not found, a 404 response is returned. If the status update is successful, a JSON response
     * with the updated record is returned. In case of an error during the update, a 500 response is returned.
     *
     * @param string $id The ID of the record whose status is to be toggled.
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the operation.
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
     * Soft deletes all records in the Task model.
     *
     * This method retrieves all records from the Task model and soft deletes them.
     * If no records are found, a 404 response is returned. If the deletion is successful,
     * a 204 No Content response is returned. In case of an error during deletion, a 500 response
     * is returned.
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse Response indicating the result of the operation.
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
     * Soft deletes a record by its ID.
     *
     * This method attempts to find a record by its ID and soft delete it. If the record
     * is not found, a 404 response is returned. If the deletion is successful, a 204
     * No Content response is returned. In case of an error during deletion, a 500 response
     * is returned.
     *
     * @param string $id The ID of the record to be deleted.
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse Response indicating the result of the operation.
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
     * Restores all soft-deleted records within the current day.
     *
     * This method retrieves all records that were soft-deleted within the current day
     * and restores them. If no records are found, a 404 response is returned. In case
     * of an error during restoration, a 500 response is returned.
     *
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the operation.
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
     * Restores a soft-deleted record by its ID.
     *
     * This method attempts to find a soft-deleted record by its ID and restore it. If the record
     * is not found, a 404 response is returned. If the restoration is successful, a JSON response
     * with the restored record is returned. In case of an error during restoration, a 500 response
     * is returned.
     *
     * @param string $id The ID of the record to be restored.
     * @return \Illuminate\Http\JsonResponse JSON response with the result of the operation.
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
