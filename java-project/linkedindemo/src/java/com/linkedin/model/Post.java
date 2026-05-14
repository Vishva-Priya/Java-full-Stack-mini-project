package com.linkedin.model;

import java.sql.Timestamp;

public class Post {
    private int id;
    private int userId;
    private String content;
    private Timestamp createdAt;
    private String authorName;
    private String authorHeadline;

    // Constructors
    public Post() {}

    public Post(int userId, String content) {
        this.userId = userId;
        this.content = content;
    }

    // Getters and Setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public int getUserId() { return userId; }
    public void setUserId(int userId) { this.userId = userId; }

    public String getContent() { return content; }
    public void setContent(String content) { this.content = content; }

    public Timestamp getCreatedAt() { return createdAt; }
    public void setCreatedAt(Timestamp createdAt) { this.createdAt = createdAt; }

    public String getAuthorName() { return authorName; }
    public void setAuthorName(String authorName) { this.authorName = authorName; }

    public String getAuthorHeadline() { return authorHeadline; }
    public void setAuthorHeadline(String authorHeadline) { this.authorHeadline = authorHeadline; }
}