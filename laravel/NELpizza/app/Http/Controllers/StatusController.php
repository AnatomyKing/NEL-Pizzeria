<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bestelling;

class StatusController extends Controller
{
    /**
     * Returns a JSON array of statuses keyed by order ID.
     * Example response:
     * {
     *   "1": "besteld",
     *   "2": "bereiden",
     *   "5": "bezorgd"
     * }
     */
    public function getStatuses(Request $request)
    {
        // Expecting an array of IDs in the request body: { "ids": [1,2,3] }
        $ids = $request->input('ids', []);

        // Find all orders that match these IDs
        $bestellingen = Bestelling::whereIn('id', $ids)->get(['id', 'status']);

        // Pluck out "status" keyed by "id"
        // e.g. [1 => 'besteld', 2 => 'bereiden', ...]
        $statuses = $bestellingen->pluck('status', 'id')->toArray();

        return response()->json($statuses);
    }

    /**
     * Updates a single order's status if it exists.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:besteld,bereiden,inoven,uitoven,onderweg,bezorgd,geannuleerd'
        ]);

        $bestelling = Bestelling::find($id);

        if (!$bestelling) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $bestelling->status = $request->status;
        $bestelling->save();

        return response()->json(['message' => 'Status updated successfully']);
    }
}