<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bestelling;

class StatusController extends Controller
{
    public function getStatus($id)
    {
        $bestelling = Bestelling::find($id);

        if (!$bestelling) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json([
            'status' => $bestelling->status
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:initieel,betaald,bereiden,inoven,onderweg,bezorgd'
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
