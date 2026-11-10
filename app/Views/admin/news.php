<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="fw-bold mb-1">News & Events Management</h3>
    <p class="text-muted small mb-0">Publish notices, AGM announcements, press releases, and circulars.</p>
  </div>
  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newNewsModal">
    <i class="fa-solid fa-plus me-1"></i> Publish Article
  </button>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-muted small text-uppercase">
          <tr>
            <th class="ps-3 py-3">Publish Date</th>
            <th class="py-3">Article Title (English)</th>
            <th class="py-3">Title (Malayalam)</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end pe-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($news)): ?>
            <tr>
              <td colspan="5" class="text-center py-5 text-muted">No news articles found.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($news as $n): ?>
              <tr>
                <td class="ps-3 small text-muted font-monospace"><?= date('d M Y', strtotime($n['publish_date'])) ?></td>
                <td>
                  <div class="fw-bold text-dark"><?= e($n['title_en']) ?></div>
                  <div class="small text-muted text-truncate" style="max-width: 300px;"><?= e($n['excerpt_en'] ?? '') ?></div>
                </td>
                <td class="fw-medium text-dark small">
                  <?= e($n['title_ml']) ?>
                </td>
                <td>
                  <span class="badge bg-<?= $n['status'] === 'published' ? 'success' : 'secondary' ?> text-uppercase">
                    <?= e($n['status']) ?>
                  </span>
                </td>
                <td class="text-end pe-3">
                  <a href="/news/<?= e($n['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary me-1">
                    <i class="fa-solid fa-eye"></i> View
                  </a>
                  <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editNewsModal<?= $n['id'] ?>">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                  </button>
                </td>
              </tr>

              <!-- Edit Modal -->
              <div class="modal fade" id="editNewsModal<?= $n['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <form action="/admin/news/save" method="POST">
                      <?= csrf_field() ?>
                      <input type="hidden" name="id" value="<?= $n['id'] ?>">
                      <div class="modal-header">
                        <h5 class="modal-title fw-bold">Edit Article</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row g-3">
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Title (English)</label>
                            <input type="text" name="title_en" class="form-control" value="<?= e($n['title_en']) ?>" required>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Title (Malayalam)</label>
                            <input type="text" name="title_ml" class="form-control" value="<?= e($n['title_ml']) ?>" required>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Short Excerpt (English)</label>
                            <textarea name="excerpt_en" class="form-control" rows="2"><?= e($n['excerpt_en'] ?? '') ?></textarea>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Short Excerpt (Malayalam)</label>
                            <textarea name="excerpt_ml" class="form-control" rows="2"><?= e($n['excerpt_ml'] ?? '') ?></textarea>
                          </div>
                          <div class="col-12">
                            <label class="form-label small fw-bold">Full Story (English)</label>
                            <textarea name="body_en" class="form-control" rows="4"><?= e($n['body_en'] ?? '') ?></textarea>
                          </div>
                          <div class="col-12">
                            <label class="form-label small fw-bold">Full Story (Malayalam)</label>
                            <textarea name="body_ml" class="form-control" rows="4"><?= e($n['body_ml'] ?? '') ?></textarea>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Publish Date</label>
                            <input type="date" name="publish_date" class="form-control" value="<?= e($n['publish_date']) ?>" required>
                          </div>
                          <div class="col-md-6">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                              <option value="published" <?= $n['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                              <option value="draft" <?= $n['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                            </select>
                          </div>
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
    </div>
  </div>
</div>

<!-- New Article Modal -->
<div class="modal fade" id="newNewsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="/admin/news/save" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="0">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Publish News Article</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label small fw-bold">Title (English)</label>
              <input type="text" name="title_en" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Title (Malayalam)</label>
              <input type="text" name="title_ml" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label small fw-bold">Full Story (English)</label>
              <textarea name="body_en" class="form-control" rows="4"></textarea>
            </div>
            <div class="col-12">
              <label class="form-label small fw-bold">Full Story (Malayalam)</label>
              <textarea name="body_ml" class="form-control" rows="4"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Publish Date</label>
              <input type="date" name="publish_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Status</label>
              <select name="status" class="form-select">
                <option value="published">Published</option>
                <option value="draft">Draft</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm">Publish</button>
        </div>
      </form>
    </div>
  </div>
</div>
