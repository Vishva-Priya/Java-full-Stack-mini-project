<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="com.linkedin.model.User" %>
<%@ page import="com.linkedin.model.Connection" %>
<%@ page import="java.util.List" %>
<%@ page import="java.text.SimpleDateFormat" %>
<%
    User user = (User) session.getAttribute("user");
    if (user == null) {
        response.sendRedirect("login");
        return;
    }
    
    List<Connection> pendingRequests = (List<Connection>) request.getAttribute("pendingRequests");
    List<Connection> sentRequests = (List<Connection>) request.getAttribute("sentRequests");
    List<Connection> connections = (List<Connection>) request.getAttribute("connections");
    List<User> suggestedUsers = (List<User>) request.getAttribute("suggestedUsers");
    
    String message = (String) request.getAttribute("message");
    String error = (String) request.getAttribute("error");
%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Network - LinkedIn Clone</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="home">
                <i class="fab fa-linkedin"></i> LinkedIn Clone
            </a>
            
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="home"><i class="fas fa-home"></i> Home</a>
                <a class="nav-link active" href="connections"><i class="fas fa-users"></i> Connections</a>
                <a class="nav-link" href="profile"><i class="fas fa-user"></i> Profile</a>
                <a class="nav-link" href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Success/Error Messages -->
        <% if (message != null) { %>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <%= message %>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <% } %>
        
        <% if (error != null) { %>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <%= error %>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <% } %>

        <div class="row">
            <div class="col-md-8">
                <!-- Pending Connection Requests -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user-clock"></i> Pending Requests
                        </h5>
                        <% if (pendingRequests != null && !pendingRequests.isEmpty()) { %>
                            <span class="badge bg-primary"><%= pendingRequests.size() %></span>
                        <% } %>
                    </div>
                    <div class="card-body">
                        <% if (pendingRequests != null && !pendingRequests.isEmpty()) { %>
                            <% SimpleDateFormat sdf = new SimpleDateFormat("MMM dd, yyyy"); %>
                            <% for (Connection connReq : pendingRequests) { %>
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                                        </div>
                                        <div>
                                            <input type="hidden" name="requestId" value="<%= connReq.getId() %>">

                                            <p class="text-muted small mb-1">
                                               <input type="hidden" name="requestId" value="<%= connReq.getId() %>">

                                            </p>
                                            <small class="text-muted">
                                                Sent <%= sdf.format(request.getCreatedAt()) %>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <form method="post" action="connections" style="display: inline;">
                                            <input type="hidden" name="action" value="accept">
                                            <input type="hidden" name="requestId" value="<%= request.getId() %>">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-check"></i> Accept
                                            </button>
                                        </form>
                                        <form method="post" action="connections" style="display: inline;">
                                            <input type="hidden" name="action" value="reject">
                                            <input type="hidden" name="requestId" value="<%= request.getId() %>">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm ms-2">
                                                <i class="fas fa-times"></i> Decline
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <% } %>
                        <% } else { %>
                            <div class="text-center py-4">
                                <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No pending connection requests.</p>
                            </div>
                        <% } %>
                    </div>
                </div>

                <!-- Your Connections -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-users"></i> Your Connections
                        </h5>
                        <% if (connections != null && !connections.isEmpty()) { %>
                            <span class="badge bg-success"><%= connections.size() %></span>
                        <% } %>
                    </div>
                    <div class="card-body">
                        <% if (connections != null && !connections.isEmpty()) { %>
                            <% SimpleDateFormat sdf = new SimpleDateFormat("MMM dd, yyyy"); %>
                            <% for (Connection connection : connections) { %>
                                <% User connectedUser = connection.getRequester().getId() == user.getId() ? 
                                       connection.getAddressee() : connection.getRequester(); %>
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <i class="fas fa-user-circle fa-2x text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">
                                                <a href="profile?id=<%= connectedUser.getId() %>" class="text-decoration-none">
                                                    <%= connectedUser.getFullName() %>
                                                </a>
                                            </h6>
                                            <p class="text-muted small mb-1">
                                                <%= connectedUser.getHeadline() != null ? connectedUser.getHeadline() : "Professional" %>
                                            </p>
                                            <% if (connectedUser.getLocation() != null) { %>
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt"></i> <%= connectedUser.getLocation() %>
                                                </small>
                                            <% } %>
                                        </div>
                                    </div>
                                    <div>
                                        <small class="text-muted">Connected <%= sdf.format(connection.getCreatedAt()) %></small>
                                    </div>
                                </div>
                            <% } %>
                        <% } else { %>
                            <div class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">You don't have any connections yet.</p>
                                <p class="text-muted">Start connecting with people you know!</p>
                            </div>
                        <% } %>
                    </div>
                </div>

                <!-- Sent Requests -->
                <% if (sentRequests != null && !sentRequests.isEmpty()) { %>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-paper-plane"></i> Sent Requests
                            </h5>
                        </div>
                        <div class="card-body">
                            <% SimpleDateFormat sdf = new SimpleDateFormat("MMM dd, yyyy"); %>
                            <% for (Connection request : sentRequests) { %>
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <i class="fas fa-user-circle fa-2x text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1"><%= request.getAddressee().getFullName() %></h6>
                                            <p class="text-muted small mb-1">
                                                <%= request.getAddressee().getHeadline() != null ? request.getAddressee().getHeadline() : "Professional" %>
                                            </p>
                                            <small class="text-muted">
                                                Sent <%= sdf.format(request.getCreatedAt()) %>
                                            </small>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="badge bg-warning">Pending</span>
                                        <form method="post" action="connections" style="display: inline;">
                                            <input type="hidden" name="action" value="cancel">
                                            <input type="hidden" name="requestId" value="<%= request.getId() %>">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm ms-2">
                                                <i class="fas fa-times"></i> Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <% } %>
                        </div>
                    </div>
                <% } %>
            </div>

            <div class="col-md-4">
                <!-- People You May Know -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-user-plus"></i> People You May Know
                        </h6>
                    </div>
                    <div class="card-body">
                        <% if (suggestedUsers != null && !suggestedUsers.isEmpty()) { %>
                            <% for (User suggestedUser : suggestedUsers) { %>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <i class="fas fa-user-circle fa-lg text-secondary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 small">
                                                <a href="profile?id=<%= suggestedUser.getId() %>" class="text-decoration-none">
                                                    <%= suggestedUser.getFullName() %>
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <%= suggestedUser.getHeadline() != null ? suggestedUser.getHeadline() : "Professional" %>
                                            </small>
                                        </div>
                                    </div>
                                    <form method="post" action="connections">
                                        <input type="hidden" name="action" value="send">
                                        <input type="hidden" name="addresseeId" value="<%= suggestedUser.getId() %>">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            <% } %>
                        <% } else { %>
                            <div class="text-center py-3">
                                <i class="fas fa-user-plus fa-2x text-muted mb-2"></i>
                                <p class="text-muted small">No suggestions available.</p>
                            </div>
                        <% } %>
                    </div>
                </div>

                <!-- Connection Stats -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-bar"></i> Your Network
                        </h6>
                    </div>
                    <div class="card-body">
                        
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-primary mb-0">
                                        <%= connections != null ? connections.size() : 0 %>
                                    </h4>
                                    <small class="text-muted">Connections</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-warning mb-0">
                                    <%= pendingRequests != null ? pendingRequests.size() : 0 %>
                                </h4>
                                <small class="text-muted">Pending</small>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>