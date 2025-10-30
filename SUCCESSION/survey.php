  <!-- Modals -->
    <dialog id="createSurveyModal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="font-bold text-lg">Create New Survey</h3>
            <div class="py-4">
                <form id="survey-form">
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Survey Name</span>
                        </label>
                        <input type="text" placeholder="Type here" class="input input-bordered w-full" required />
                    </div>
                    
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Survey Type</span>
                        </label>
                        <select class="select select-bordered" required>
                            <option disabled selected>Select survey type</option>
                            <option>Manager Assessment</option>
                            <option>Peer Review</option>
                            <option>Mentor Evaluation</option>
                            <option>360° Feedback</option>
                        </select>
                    </div>
                    
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Competencies to Measure</span>
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="cursor-pointer label justify-start">
                                <input type="checkbox" checked="checked" class="checkbox checkbox-primary mr-2" />
                                <span class="label-text">Strategic Thinking</span>
                            </label>
                            <label class="cursor-pointer label justify-start">
                                <input type="checkbox" checked="checked" class="checkbox checkbox-primary mr-2" />
                                <span class="label-text">Problem-Solving</span>
                            </label>
                            <label class="cursor-pointer label justify-start">
                                <input type="checkbox" checked="checked" class="checkbox checkbox-primary mr-2" />
                                <span class="label-text">Decision-Making</span>
                            </label>
                            <label class="cursor-pointer label justify-start">
                                <input type="checkbox" checked="checked" class="checkbox checkbox-primary mr-2" />
                                <span class="label-text">Adaptability</span>
                            </label>
                            <label class="cursor-pointer label justify-start">
                                <input type="checkbox" class="checkbox checkbox-primary mr-2" />
                                <span class="label-text">Communication</span>
                            </label>
                            <label class="cursor-pointer label justify-start">
                                <input type="checkbox" class="checkbox checkbox-primary mr-2" />
                                <span class="label-text">Team Leadership</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Participants</span>
                        </label>
                        <select class="select select-bordered" multiple required>
                            <option>John Smith (Marketing)</option>
                            <option>Jane Doe (Engineering)</option>
                            <option>Amanda Rodriguez (Sales)</option>
                            <option>Michael Chen (Product)</option>
                            <option>Sarah Johnson (HR)</option>
                        </select>
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Due Date</span>
                        </label>
                        <input type="date" class="input input-bordered w-full" required />
                    </div>
                </form>
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost">Cancel</button>
                </form>
                <button class="btn btn-primary" onclick="createSurvey()">Create Survey</button>
            </div>
        </div>
    </dialog>

    <dialog id="surveyResultsModal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="font-bold text-lg" id="results-title">Survey Results</h3>
            <div class="py-4">
                <div class="h-64 mb-4">
                    <canvas id="surveyResultsChart"></canvas>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Participant</th>
                                <th>Role</th>
                                <th>Completed</th>
                                <th>Average Score</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="results-table">
                            <!-- Results will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>