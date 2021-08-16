<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailRequest;
use App\Jobs\SubscribersParseFromFileJob;
use App\Mail\SubscriberMail;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use League\Csv\Reader;
use League\Csv\Statement;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $subscribers = Subscriber::orderBy($request->sortBy ?? 'id', $request->desc ? 'DESC' : 'ASC')
            ->paginate($request->perPage ?? '10');

        return view('subscribers.list', compact('subscribers'));
    }

    public function loadFile(Request $request)
    {
        $path = $request->file('file')->store('file');
        SubscribersParseFromFileJob::dispatch($path);

        $subscribers = Subscriber::orderBy($request->sortBy ?? 'id', $request->desc ? 'DESC' : 'ASC')
            ->paginate($request->perPage ?? '10');

        return view('subscribers.list', compact('subscribers'));
    }

    public function sendEmail(Request $request, Subscriber $subscriber)
    {
        Mail::to($subscriber->email)->send(new SubscriberMail($subscriber));

        return redirect()->route('subscribers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscriber $subscriber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        //
    }
}
