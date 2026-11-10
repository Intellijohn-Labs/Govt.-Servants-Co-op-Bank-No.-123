-- Content update for kalliaseri-scb (SQLite). Rates figures in %, financial figures in Rs Lakhs.
UPDATE banners SET
  title_en    = '100 Years of Service Legacy | Class 1 Bank',
  title_ml    = '100 വർഷങ്ങളുടെ സേവനപാരമ്പര്യം | Class 1 ബാങ്ക്',
  subtitle_en = 'Attractive deposit schemes',
  subtitle_ml = 'ആകർഷകമായ നിക്ഷേപ പദ്ധതികൾ'
WHERE client_slug = 'kalliaseri-scb' AND sort_order = 1;

DELETE FROM achievements WHERE client_slug = 'kalliaseri-scb';
INSERT INTO achievements (client_slug, title_en, title_ml, count_value, suffix, icon, sort_order) VALUES
 ('kalliaseri-scb','Working Capital (₹ Lakhs)','പ്രവർത്തന മൂലധനം (ലക്ഷം രൂപ)','7010.23','','fa-chart-line',1),
 ('kalliaseri-scb','Total Deposits (₹ Lakhs)','നിക്ഷേപ ബാക്കി (ലക്ഷം രൂപ)','6923.74','','fa-piggy-bank',2),
 ('kalliaseri-scb','Total Loans (₹ Lakhs)','വായ്പാ ബാക്കി (ലക്ഷം രൂപ)','5093.62','','fa-hand-holding-dollar',3),
 ('kalliaseri-scb','Share Capital (₹ Lakhs)','ഓഹരി മൂലധനം (ലക്ഷം രൂപ)','110.70','','fa-coins',4);

-- General loan rate table slabs (no dedicated product page)
INSERT INTO product_rates (client_slug, product_id, category_type, tenure_label_en, tenure_label_ml, general_rate, senior_rate, effective_from, is_active, sort_order) VALUES
 ('kalliaseri-scb', NULL, 'loan', 'Loans up to ₹4 Lakhs', '4 ലക്ഷം വരെ', 9.50, 9.50, '2026-11-10', 1, 0),
 ('kalliaseri-scb', NULL, 'loan', '₹4 Lakh to ₹8 Lakh', '₹4 ലക്ഷം മുതൽ ₹8 ലക്ഷം വരെ', 10.50, 10.50, '2026-11-10', 1, 0),
 ('kalliaseri-scb', NULL, 'loan', 'Loans above ₹8 Lakhs', '8 ലക്ഷത്തിന് മുകളിൽ', 11.50, 11.50, '2026-11-10', 1, 0);

-- Deactivate placeholder template loan rates (keep only the approved slabs above)
UPDATE product_rates SET is_active = 0
WHERE client_slug = 'kalliaseri-scb' AND category_type = 'loan'
  AND tenure_label_en IN ('Gold Loan (Swarna Nidhi)', 'Housing Loan (Home Construction)',
                          'Kisan Agricultural Loan', 'SME Business & Trader Credit', 'Vehicle & Two Wheeler Loan');

-- ===== Hide template filler (reversible: set status back to published/active) =====
UPDATE news            SET status = 'draft'    WHERE client_slug = 'kalliaseri-scb';
UPDATE board_members   SET status = 'inactive' WHERE client_slug = 'kalliaseri-scb';
UPDATE announcements   SET is_active = 0       WHERE client_slug = 'kalliaseri-scb';
UPDATE downloads       SET status = 'inactive' WHERE client_slug = 'kalliaseri-scb';
UPDATE products        SET status = 'draft'    WHERE client_slug = 'kalliaseri-scb';
UPDATE product_rates   SET is_active = 0       WHERE client_slug = 'kalliaseri-scb' AND category_type = 'deposit';
DELETE FROM tenders WHERE client_slug = 'kalliaseri-scb';
DELETE FROM careers WHERE client_slug = 'kalliaseri-scb';
-- Keep only the head office so the (mandatory) branch selector in forms still works
UPDATE branches SET status = 'inactive' WHERE client_slug = 'kalliaseri-scb' AND is_head_office = 0;
UPDATE branches SET manager_name = NULL, manager_phone = NULL, has_365_days = 0, has_locker = 0, has_gold_loan = 0, has_atm = 0
 WHERE client_slug = 'kalliaseri-scb' AND is_head_office = 1;

-- Short slab badges for the loan table
UPDATE product_rates SET notes_en = '≤ ₹4L',        notes_ml = '4 ലക്ഷം വരെ'        WHERE client_slug='kalliaseri-scb' AND tenure_label_en = 'Loans up to ₹4 Lakhs';
UPDATE product_rates SET notes_en = '₹4L – ₹8L',    notes_ml = '4 – 8 ലക്ഷം'        WHERE client_slug='kalliaseri-scb' AND tenure_label_en = '₹4 Lakh to ₹8 Lakh';
UPDATE product_rates SET notes_en = '> ₹8L',        notes_ml = '8 ലക്ഷത്തിന് മുകളിൽ' WHERE client_slug='kalliaseri-scb' AND tenure_label_en = 'Loans above ₹8 Lakhs';

-- ===== Authentic institution details (Govt. Servants' Co-operative Bank Ltd. No. 123, N. Paravur) =====
UPDATE branches SET code = 'HO-01', name_en = 'Head Office', name_ml = 'ഹെഡ് ഓഫീസ്',
       address_en = 'Court Complex West, N. Paravur, Ernakulam, Kerala - 683513',
       address_ml = 'കോടതി സമുച്ചയത്തിന് പടിഞ്ഞാറുവശം, എൻ. പറവൂർ, എറണാകുളം, കേരളം - 683513',
       district = 'Ernakulam', pincode = '683513', phone = '0484-2442693', alternate_phone = NULL,
       email = 'gscb123paravur@gmail.com',
       working_hours_en = 'Monday – Saturday: 9:30 AM – 4:30 PM (Sunday Closed)',
       working_hours_ml = 'തിങ്കൾ – ശനി: 9:30 AM – 4:30 PM (ഞായർ അവധി)',
       latitude = 10.1472, longitude = 76.2295, directions_url = NULL
WHERE client_slug = 'kalliaseri-scb' AND is_head_office = 1;

-- ===== Audit fixes: tidy slab-2 label (idempotent for databases migrated before this change) =====
UPDATE product_rates SET tenure_label_en = '₹4 Lakh to ₹8 Lakh', tenure_label_ml = '₹4 ലക്ഷം മുതൽ ₹8 ലക്ഷം വരെ'
WHERE client_slug = 'kalliaseri-scb' AND tenure_label_en = 'Loans above ₹4 Lakhs up to ₹8 Lakhs';
UPDATE product_rates SET notes_en = '₹4L – ₹8L', notes_ml = '4 – 8 ലക്ഷം'
WHERE client_slug = 'kalliaseri-scb' AND tenure_label_en = '₹4 Lakh to ₹8 Lakh';
-- Make sure only the three approved slabs are active
UPDATE product_rates SET is_active = 0
WHERE client_slug = 'kalliaseri-scb' AND category_type = 'loan'
  AND tenure_label_en NOT IN ('Loans up to ₹4 Lakhs', '₹4 Lakh to ₹8 Lakh', 'Loans above ₹8 Lakhs');
