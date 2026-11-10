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
 ('kalliaseri-scb', NULL, 'loan', 'Loans up to ₹4 Lakhs', '4 ലക്ഷം വരെ', 9.50, 9.50, date('now'), 1, 0),
 ('kalliaseri-scb', NULL, 'loan', 'Loans above ₹4 Lakhs up to ₹8 Lakhs', '4 ലക്ഷത്തിന് മുകളിൽ 8 ലക്ഷം വരെ', 10.50, 10.50, date('now'), 1, 0),
 ('kalliaseri-scb', NULL, 'loan', 'Loans above ₹8 Lakhs', '8 ലക്ഷത്തിന് മുകളിൽ', 11.50, 11.50, date('now'), 1, 0);

-- Deactivate placeholder template loan rates (keep only the approved slabs above)
UPDATE product_rates SET is_active = 0
WHERE client_slug = 'kalliaseri-scb' AND category_type = 'loan' AND tenure_label_en NOT LIKE 'Loans %';
