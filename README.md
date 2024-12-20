# Employee Performance System Task Plan

## Performance Metrics
- **Attendance Rate (%)**: Percentage of days an employee was present during a given period.
- **Average Task Efficiency (%)**: Time taken to complete a task compared to the expected time, averaged across tasks.

---

## Task Plan

### 1. View Employees
- **Objective**: Display a list of employees with their performance metrics.
- **Steps**:
  1. Fetch all records from the employees table.
  2. Display the following columns:
     - Employee ID
     - Name
     - Designation
     - Attendance Rate
     - Average Task Efficiency
  3. Add buttons for "Edit" and "Delete" next to each record.
- **Deliverables**:
  - A PHP page displaying the list of employees in a table format.

---

### 2. Edit Employee
- **Objective**: Implement functionality to update employee data.
- **Steps**:
  1. Add an "Edit" button next to each employee on the list.
  2. Clicking "Edit" should open a form pre-filled with the employee's details, including performance metrics.
  3. Allow users to modify the fields and save the changes.
  4. Update the database with the modified data using an `UPDATE` query.
- **Deliverables**:
  - A functional "Edit Employee" feature.

---

### 3. Delete Employee
- **Objective**: Implement a feature to remove an employee record.
- **Steps**:
  1. Add a "Delete" button next to each employee on the list.
  2. Clicking "Delete" should show a confirmation prompt.
  3. On confirmation, remove the record from the database using a `DELETE` query.
  4. Refresh the list after deletion.
- **Deliverables**:
  - A functional "Delete Employee" feature with confirmation.

---

### 4. Add Performance Validation
- **Objective**: Implement validation rules for performance metrics.
- **Steps**:
  1. Validate that numerical metrics (e.g., Attendance Rate, Average Task Efficiency) are between 0 and 100.
  2. Display error messages for invalid inputs.
- **Deliverables**:
  - Validated forms that display appropriate error messages when invalid data is entered.

---

### 5. Optimize and Review
- **Objective**: Ensure secure and clean code.
- **Steps**:
  1. Use prepared statements to prevent SQL injection.
  2. Ensure proper error handling for database operations.
- **Deliverables**:
  - Secure and well-documented code.

---

## Bonus Challenges

### Pagination
- **Objective**: Add pagination to the employee list to improve usability for large datasets.
- **Steps**:
  1. Fetch a limited number of records (e.g., 10 per page) from the database using `LIMIT` and `OFFSET`.
  2. Add "Previous" and "Next" buttons to navigate between pages.
- **Deliverables**:
  - Paginated employee list.

---

### Search
- **Objective**: Allow users to search employees by name or designation.
- **Steps**:
  1. Add a search bar above the employee table.
  2. Filter the table based on the input.
  3. Use a `WHERE` clause in the SQL query to fetch relevant records.
- **Deliverables**:
  - A search feature that dynamically filters the employee list.

---

### Sorting
- **Objective**: Allow sorting of employees by performance metrics.
- **Steps**:
  1. Add clickable headers in the employee table for sorting columns like Attendance Rate or Goals Achieved.
  2. Modify the SQL query to include an `ORDER BY` clause based on the selected column.
- **Deliverables**:
  - Sorting functionality for employee records.
