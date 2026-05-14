<%
    com.linkedin.model.User profileUser = (com.linkedin.model.User) request.getAttribute("profileUser");
%>

<input type="text" class="form-control" id="location" name="location" 
                                       value="<%= profileUser.getLocation() != null ? profileUser.getLocation() : ""%>">
                            </div>
                            <div class="mb-3">
                                <label for="summary" class="form-label">Summary</label>
                                <textarea class="form-control" id="summary" name="summary" rows="4"><%= profileUser.getSummary() != null ? profileUser.getSummary() : "" %></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <% } %>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>