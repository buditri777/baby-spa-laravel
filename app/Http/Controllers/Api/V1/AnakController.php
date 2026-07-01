<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Child;
use Illuminate\Http\Request;

class AnakController extends Controller
{
    public function index(Request $request)
    {
        $children = Child::where('parent_id', $request->user()->id)
            ->orderBy('name')->get();
        return response()->json($children);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'gender'             => 'required|in:L,P',
            'birth_date'         => 'required|date',
            'birth_weight_g'     => 'nullable|integer',
            'birth_height_cm'    => 'nullable|numeric',
            'delivery_type'      => 'nullable|in:NORMAL,SC,VACUUM,FORCEPS',
            'allergies'          => 'nullable|string',
            'medical_conditions' => 'nullable|string',
            'notes'              => 'nullable|string',
        ]);
        $data['parent_id'] = $request->user()->id;
        $child = Child::create($data);
        return response()->json($child, 201);
    }

    public function show(Request $request, string $id)
    {
        $child = Child::where('id', $id)->firstOrFail();
        $this->authorizeChild($request, $child);
        return response()->json($child->load(['bookings.service','bookings.therapist']));
    }

    public function update(Request $request, string $id)
    {
        $child = Child::where('id', $id)->firstOrFail();
        $this->authorizeChild($request, $child);
        $child->update($request->only(['name','gender','birth_date','birth_weight_g','birth_height_cm','delivery_type','allergies','medical_conditions','notes']));
        return response()->json($child->fresh());
    }

    public function growth(Request $request, string $id)
    {
        $child = Child::where('id', $id)->firstOrFail();
        $this->authorizeChild($request, $child);
        return response()->json($child->growthMeasurements()->orderByDesc('measured_at')->get());
    }

    public function milestones(Request $request, string $id)
    {
        $child = Child::where('id', $id)->firstOrFail();
        $this->authorizeChild($request, $child);
        return response()->json($child->milestones()->get());
    }

    public function exercises(Request $request, string $id)
    {
        $child = Child::where('id', $id)->firstOrFail();
        $this->authorizeChild($request, $child);
        return response()->json($child->homeExercises()->orderByDesc('created_at')->get());
    }

    public function ringkasan(Request $request, string $id)
    {
        $child = Child::where('id', $id)->firstOrFail();
        $this->authorizeChild($request, $child);
        return response()->json([
            'child'          => $child,
            'age_months'     => $child->ageInMonths(),
            'total_sessions' => $child->bookings()->where('status','COMPLETED')->count(),
            'last_booking'   => $child->bookings()->where('status','COMPLETED')->latest('scheduled_at')->first(),
        ]);
    }

    private function authorizeChild(Request $request, Child $child): void
    {
        $user = $request->user();
        if ($user->role === 'PARENT' && $child->parent_id !== $user->id) abort(403);
    }
}
