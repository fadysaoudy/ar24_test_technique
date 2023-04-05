@extends('layouts.app')

@section('create_user_form')
    @dump($errors)
    <div class="container w-50">
        <form class="mx-auto my-5" method="POST" action="{{ route('user.store') }}">
            @CSRF
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="firstname" id="firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="lastname" id="lastname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="billing_email" class="form-label">Billing Email <span class="text-danger">*</span></label>
                <input type="billing_email" class="form-control" name="billing_email" id="billing_email" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                <select class="form-select" id="gender" name="gender" required>
                    <option value=""></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="statut" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="statut" name="statut" required>
                    <option value=""></option>
                    <option value="particulier">Particulier</option>
                    <option value="professionnel">Professionnel</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="company" class="form-label">Company Name</label>
                <input type="text" class="form-control" name="company" id="company">
            </div>
            <div class="mb-3">
                <label for="company_siret" class="form-label">Company SIRET</label>
                <input type="text" class="form-control" name="company_siret" id="company_siret">
            </div>
            <div class="mb-3">
                <label for="company_tva" class="form-label">Company TVA</label>
                <input type="text" name="company_tva" class="form-control" id="company_tva">
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                <input type="text" name="country" class="form-control" id="country" required>
            </div>
            <div class="mb-3">
                <label for="address1" class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                <input type="text" name="address1" class="form-control" id="address1" required>
            </div>
            <div class="mb-3">
                <label for="address2" class="form-label">Address Line 2</label>
                <input type="text" name="address2" class="form-control" id="address2">
            </div>
            <div class="mb-3">
                <label for="zipcode" class="form-label">Zipcode<span class="text-danger">*</span></label>
                <input type="text" name="zipcode" class="form-control" id="zipcode" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City<span class="text-danger">*</span></label>
                <input type="text" name="city" class="form-control" id="city" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="confirmed" class="form-label">Ask email confirmation</label>
                <select class="form-select" id="confirmed" name="confirmed">
                    <option value="0">Not confirmed, ask for confirmation</option>
                    <option value="1">Already confirmed</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="cgu" class="form-label">Confirm user has accepted AR24 Terms and Conditions</label>
                <select class="form-select" id="cgu" name="cgu">
                    <option value="0">Not accepted, send email asking to accept</option>
                    <option value="1">Accepted</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notify_ev" class="form-label">Send "submission and initial presentation"
                    notifications</label>
                <select class="form-select" id="notify_ev" name="notify_ev">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notify_ar" class="form-label">Send "reception" notifications</label>
                <select class="form-select" id="notify_ar" name="notify_ar">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notify_rf" class="form-label">Send "refusal" notifications</label>
                <select class="form-select" id="notify_rf" name="notify_rf">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notify_ng" class="form-label">Send "negligence" notifications</label>
                <select class="form-select" id="notify_ng" name="notify_ng">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notify_consent" class="form-label">Send "consent" notifications</label>
                <select class="form-select" id="notify_consent" name="notify_consent">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notify_eidas_to_valid" class="form-label">Send notification to valid eIDAS from team</label>
                <select class="form-select" id="notify_eidas_to_valid" name="notify_eidas_to_valid">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notify_recipient_update" class="form-label">Send notification when a recipient update is
                    created</label>
                <select class="form-select" id="notify_recipient_update" name="notify_recipient_update">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notify_waiting_ar_answer" class="form-label">Send twice a week a list of waiting
                    sending</label>
                <select class="form-select" id="notify_waiting_ar_answer" name="notify_waiting_ar_answer">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="notify_recipient_update" class="form-label">Send twice a week a list of waiting sending</label>
                <select class="form-select" id="notify_recipient_update" name="notify_recipient_update">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="is_legal_entity" class="form-label">Legal Entity</label>
                <select class="form-select" id="is_legal_entity" name="is_legal_entity">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
