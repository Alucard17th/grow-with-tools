<!-- Button trigger modal -->
<button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#syncStatus">
    Synchronize Platforms
</button>

<!-- Modal -->
<div class="modal fade" id="syncStatus" tabindex="-1" aria-labelledby="syncStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="syncStatusLabel">Synchronize your platforms</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    @php
                        $igToken = \App\Models\InstagramToken::where('user_id', auth()->id())->first();
                        $tiktokToken = \App\Models\TikTokToken::where('user_id', auth()->id())->first();
                    @endphp

                    <div class="col-md-6 mb-3">
                        @php
                            $tiktokValid = $tiktokToken && $tiktokToken->expires_at && $tiktokToken->expires_at->isFuture();
                        @endphp
                        <div class="alert d-flex flex-column align-items-center justify-content-center py-4 {{ $tiktokValid ? 'text-success' : 'text-danger' }}"
                             style="background-color: {{ $tiktokValid ? '#d4edda' : '#f8d7da' }}; border-radius: 12px;">
                            <x-svg name="tiktok" width="48" height="48" class="mb-3"/>
                            @if($tiktokValid)
                                TikTok connected
                                <ul>
                                  <li><strong>User ID:</strong> {{ $tiktokToken->tiktok_user_id }}</li>
                                  <li><strong>Expires At:</strong> {{ $tiktokToken->expires_at->diffForHumans() }}</li>
                                </ul>
                            @else
                                TikTok not connected or token expired
                                <a class="btn btn-outline-secondary mt-2" href="{{ route('tiktok.connect') }}">
                                    Connect TikTok
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        @php
                            $igValid = $igToken && $igToken->expires_at && $igToken->expires_at->isFuture();
                        @endphp
                        <div class="alert d-flex flex-column align-items-center justify-content-center py-4 {{ $igValid ? 'text-success' : 'text-danger' }}"
                             style="background-color: {{ $igValid ? '#d4edda' : '#f8d7da' }}; border-radius: 12px;">
                            <x-svg name="instagram" width="48" height="48" class="mb-3"/>
                            @if($igValid)
                                Instagram connected
                                <a class="btn btn-outline-secondary mt-2" href="{{ route('instagram.redirect') }}">
                                    Connect Instagram
                                </a>
                                <ul>
                                  <li><strong>User ID:</strong> {{ $igToken->ig_user_id }}</li>
                                  <li><strong>Expires At:</strong> {{ optional($igToken->expires_at)->diffForHumans() }}</li>
                                </ul>
                            @else
                                Instagram not connected or token expired
                                <a class="btn btn-outline-secondary mt-2" href="{{ route('instagram.redirect') }}">
                                    Connect Instagram
                                </a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
