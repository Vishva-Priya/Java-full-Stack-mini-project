<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="com.linkedin.model.User" %>
<%@ page import="com.linkedin.model.Post" %>
<%@ page import="com.linkedin.model.Connection" %>
<%@ page import="java.util.List" %>
<%@ page import="java.text.SimpleDateFormat" %>
<%
    User user = (User) session.getAttribute("user");
    if (user == null) {
        response.sendRedirect("login");
        return;
    }
    
    List<Post> posts = (List<Post>) request.getAttribute("posts");
    List<Connection> pendingConnections = (List<Connection>) request.getAttribute("pendingConnections");
%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - LinkedIn Clone</title>
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
                <a class="nav-link" href="connections"><i class="fas fa-users"></i> Connections</a>
                <a class="nav-link" href="profile"><i class="fas fa-user"></i> Profile</a>
                <a class="nav-link" href="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <div class="avatar mb-3">
                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                        </div>
                        <h5><%= user.getFullName() %></h5>
                        <p class="text-muted"><%= user.getHeadline() != null ? user.getHeadline() : "Professional" %></p>
                        <a href="profile" class="btn btn-outline-primary btn-sm">View Profile</a>
                    </div>
                </div>

                <!-- Pending Connection Requests -->
                <% if (pendingConnections != null && !pendingConnections.isEmpty()) { %>
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Connection Requests</h6>
                        </div>
                        <div class="card-body">
                            <% for (Connection conn : pendingConnections) { %>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small><%= conn.getRequesterName() %></small>
                                    <div>
                                        <form method="post" action="connections" style="display: inline;">
                                            <input type="hidden" name="action" value="accept">
                                            <input type="hidden" name="connectionId" value="<%= conn.getId() %>">
                                            <button type="submit" class="btn btn-primary btn-sm">Accept</button>
                                        </form>
                                        <form method="post" action="connections" style="display: inline;">
                                            <input type="hidden" name="action" value="reject">
                                            <input type="hidden" name="connectionId" value="<%= conn.getId() %>">
                                            <button type="submit" class="btn btn-outline-secondary btn-sm">Reject</button>
                                        </form>
                                    </div>
                                </div>
                            <% } %>
                        </div>
                    </div>
                <% } %>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Create Post -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="post" action="post">
                            <div class="mb-3">
                                <textarea class="form-control" name="content" rows="3" 
                                          placeholder="What's on your mind, <%= user.getFirstName() %>?"></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Post</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Posts Feed -->
                <% if (posts != null && !posts.isEmpty()) { %>
                    <% SimpleDateFormat sdf = new SimpleDateFormat("MMM dd, yyyy 'at' hh:mm a"); %>
                    <% for (Post post : posts) { %>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-3">
                                        <i class="fas fa-user-circle fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><%= post.getAuthorName() %></h6>
                                        <small class="text-muted">
                                            <%= post.getAuthorHeadline() != null ? post.getAuthorHeadline() : "Professional" %>
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            <%= sdf.format(post.getCreatedAt()) %>
                                        </small>
                                    </div>
                                </div>
                                <p class="card-text"><%= post.getContent() %></p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-thumbs-up"></i> Like
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-comment"></i> Comment
                                    </button>
                                    <button class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-share"></i> Share
                                    </button>
                                </div>
                            </div>
                        </div>
                    <% } %>
                <% } else { %>
                    <div class="card">
                        <div class="card-body text-center">
                            <h5>No posts yet</h5>
                            <p class="text-muted">Be the first to share something!</p>
                        </div>
                    </div>
                <% } %>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>