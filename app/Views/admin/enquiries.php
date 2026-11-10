<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">Enquiries & Service Requests</h3>
    <p class="text-muted small mb-0">Review online applications, branch loan enquiries, and update processing statuses.</p>
  </div>
</div>

<!-- Tabs & Status Filter -->
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body p-3">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
      <ul class="nav nav-pills" role="tablist">
        <li class="nav-item">
          <a class="nav-link <?= $currentTab === 'requests' ? 'active' : '' ?>" href="/admin/enquiries?tab=requests">
            <i class="fa-solid fa-file-signature me-1"></i> Online Applications (<?= count($serviceRequests) ?>)
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentTab === 'general' ? 'active' : '' ?>" href="/admin/enquiries?tab=general">
            <i class="fa-solid fa-envelope me-1"></i> Contact Enquiries (<?= count($generalEnquiries) ?>)
          </a>
        </li>
      </ul>

      <div class="d-flex align-items-center gap-2">
        <span class="small text-muted">Filter:</span>
        <a href="/admin/enquiries?tab=<?= $currentTab ?>" class="btn btn-sm <?= empty($currentStatus) ? 'btn-dark' : 'btn-outline-secondary' ?>">All</a>
        <a href="/admin/enquiries?tab=<?= $currentTab ?>&status=new" class="btn btn-sm <?= $currentStatus === 'new' ? 'btn-primary' : 'btn-outline-secondary' ?>">New</a>
        <a href="/admin/enquiries?tab=<?= $currentTab ?>&status=in_progress" class="btn btn-sm <?= $currentStatus === 'in_progress' ? 'btn-info' : 'btn-outline-secondary' ?>">In Progress</a>
        <a href="/admin/enquiries?tab=<?= $currentTab ?>&status=completed" class="btn btn-sm <?= $currentStatus === 'completed' ? 'btn-success' : 'btn-outline-secondary' ?>">Completed</a>
      </div>
    </div>
  </div>
</div>

<!-- Main Table Card -->
<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <?php if ($currentTab === 'requests'): ?>
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light text-muted small text-uppercase">
            <tr>
              <th class="ps-3 py-3">Tracking Code</th>
              <th class="py-3">Applicant Name</th>
              <th class="py-3">Service Requested</th>
              <th class="py-3">Branch</th>
              <th class="py-3">Contact</th>
              <th class="py-3">Status</th>
              <th class="py-3 text-end pe-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($serviceRequests)): ?>
              <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                  <i class="fa-solid fa-inbox fa-3x mb-2 text-secondary opacity-50"></i>
                  <div>No service requests found.</div>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($serviceRequests as $req): ?>
                <tr>
                  <td class="ps-3 font-monospace fw-bold small text-primary">
                    <?= e($req['tracking_code']) ?>
                    <div class="text-muted" style="font-size: 0.7rem;"><?= date('d M Y, h:i A', strtotime($req['created_at'])) ?></div>
                  </td>
                  <td>
                    <div class="fw-bold text-dark"><?= e($req['full_name']) ?></div>
                    <?php if (!empty($req['member_number'])): ?>
                      <span class="badge bg-light text-dark border">Member: <?= e($req['member_number']) ?></span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                      <?= e($req['request_type']) ?>
                    </span>
                    <?php if (!empty($req['message'])): ?>
                      <div class="small text-muted text-truncate" style="max-width: 200px;" title="<?= e($req['message']) ?>">
                        <?= e($req['message']) ?>
                      </div>
                    <?php endif; ?>
                  </td>
                  <td class="small text-dark">
                    <?= e($req['branch_name'] ?? 'Head Office') ?>
                  </td>
                  <td class="small">
                    <div><i class="fa-solid fa-phone text-muted me-1"></i> <a href="tel:<?= e($req['phone']) ?>" class="text-decoration-none"><?= e($req['phone']) ?></a></div>
                    <?php if (!empty($req['email']) && !str_contains($req['email'], '@customer.local')): ?>
                      <div><i class="fa-solid fa-envelope text-muted me-1"></i> <?= e($req['email']) ?></div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <span class="badge bg-<?= $req['status'] === 'completed' ? 'success' : ($req['status'] === 'in_progress' ? 'info' : ($req['status'] === 'cancelled' ? 'danger' : 'warning')) ?> text-dark text-uppercase">
                      <?= e($req['status']) ?>
                    </span>
                  </td>
                  <td class="text-end pe-3">
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $req['id'] ?>">
                      <i class="fa-solid fa-pen-to-square me-1"></i> Update
                    </button>
                  </td>
                </tr>

                <!-- Modal for Updating Request -->
                <div class="modal fade" id="editModal<?= $req['id'] ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="/admin/enquiries/update" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="item_type" value="request">
                        <input type="hidden" name="id" value="<?= $req['id'] ?>">
                        <div class="modal-header">
                          <h5 class="modal-title fw-bold">Update Request #<?= e($req['tracking_code']) ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label small fw-bold">Applicant</label>
                            <input type="text" class="form-control" value="<?= e($req['full_name']) ?> (<?= e($req['phone']) ?>)" readonly>
                          </div>
                          <div class="mb-3">
                            <label class="form-label small fw-bold">Processing Status</label>
                            <select name="status" class="form-select">
                              <option value="new" <?= $req['status'] === 'new' ? 'selected' : '' ?>>New</option>
                              <option value="in_progress" <?= $req['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress (Contacted / Under Review)</option>
                              <option value="completed" <?= $req['status'] === 'completed' ? 'selected' : '' ?>>Completed (Sanctioned / Resolved)</option>
                              <option value="cancelled" <?= $req['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled / Rejected</option>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label class="form-label small fw-bold">Internal Resolution Notes</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Enter notes (e.g. Called customer on 03/10, KYC verified, token issued...)"><?= e($req['resolution_notes'] ?? '') ?></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      <?php else: ?>
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light text-muted small text-uppercase">
            <tr>
              <th class="ps-3 py-3">Tracking Code</th>
              <th class="py-3">Name</th>
              <th class="py-3">Subject / Category</th>
              <th class="py-3">Message</th>
              <th class="py-3">Status</th>
              <th class="py-3 text-end pe-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($generalEnquiries)): ?>
              <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                  <i class="fa-solid fa-inbox fa-3x mb-2 text-secondary opacity-50"></i>
                  <div>No contact enquiries found.</div>
                </td>
              </tr>
            <?php else: ?>
              <?php foreach ($generalEnquiries as $enq): ?>
                <tr>
                  <td class="ps-3 font-monospace fw-bold small text-primary"><?= e($enq['tracking_code']) ?></td>
                  <td>
                    <div class="fw-bold"><?= e($enq['name']) ?></div>
                    <div class="small text-muted"><?= e($enq['phone']) ?> • <?= e($enq['email']) ?></div>
                  </td>
                  <td>
                    <div class="fw-semibold text-dark"><?= e($enq['subject']) ?></div>
                    <span class="badge bg-secondary-subtle text-secondary small"><?= e($enq['category']) ?></span>
                  </td>
                  <td class="small text-muted" style="max-width: 250px;">
                    <?= e($enq['message']) ?>
                  </td>
                  <td>
                    <span class="badge bg-<?= $enq['status'] === 'completed' ? 'success' : ($enq['status'] === 'in_progress' ? 'info' : 'warning') ?> text-dark text-uppercase">
                      <?= e($enq['status']) ?>
                    </span>
                  </td>
                  <td class="text-end pe-3">
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editEnqModal<?= $enq['id'] ?>">
                      <i class="fa-solid fa-pen-to-square me-1"></i> Update
                    </button>
                  </td>
                </tr>

                <div class="modal fade" id="editEnqModal<?= $enq['id'] ?>" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form action="/admin/enquiries/update" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="item_type" value="enquiry">
                        <input type="hidden" name="id" value="<?= $enq['id'] ?>">
                        <div class="modal-header">
                          <h5 class="modal-title fw-bold">Update Enquiry #<?= e($enq['tracking_code']) ?></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                              <option value="new" <?= $enq['status'] === 'new' ? 'selected' : '' ?>>New</option>
                              <option value="in_progress" <?= $enq['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                              <option value="completed" <?= $enq['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                            </select>
                          </div>
                          <div class="mb-3">
                            <label class="form-label small fw-bold">Internal Notes</label>
                            <textarea name="notes" class="form-control" rows="3"><?= e($enq['internal_notes'] ?? '') ?></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                          <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>
